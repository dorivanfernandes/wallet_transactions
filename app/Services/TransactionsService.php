<?php


namespace App\Services;


use App\Models\User;
use App\Repository\Interfaces\ITransactionsRepository;
use App\Repository\Interfaces\IUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionsService
{
    protected $transactionRepository;
    protected $userRepository;

    public function __construct(ITransactionsRepository $transaction, IUserRepository $user)
    {
        $this->transactionRepository = $transaction;
        $this->userRepository = $user;
    }

    public function all()
    {
        return $this->transactionRepository->all();
    }

    public function find(int $id)
    {
        return $this->transactionRepository->find($id);
    }

    public function create($request)
    {
        $user = Auth::user();
        $wallet_balance_payer = floatval($this->userRepository->getWalletAmount($user->id));
        if($user->user_type == 2){
            return response()->json(['Erro' => 'Lojistas não estão autorizados para fazer transações.'], 401);
        }

        if($user->id != $request['user_payer']){
            return response()->json(['Erro' => 'O usuário logado não é o usuário que está realizando a transação.'], 400);
        }

        if($user->id == $request['user_payee']){
            return response()->json(['Erro' => 'O usuário pagador e o beneficiário deve ser diferente'], 400);
        }

        if($wallet_balance_payer < $request['transaction_value']){
            return response()->json(['Erro' => 'O valor na carteira é insuficiente para essa transação.'], 400);
        }

        DB::beginTransaction();
        $wallet_balance_payer -= floatval($request['transaction_value']);
        $new_value_payer = $this->userRepository->subtractWalletValue($user->id, $wallet_balance_payer);

        $wallet_balance_payee = floatval($this->userRepository->getWalletAmount(intval($request['user_payee'])));
        $wallet_balance_payee += floatval($request['transaction_value']);
        $new_value_payee = $this->userRepository->sumWalletValue(intval($request['user_payee']), $wallet_balance_payee);

        $external_authorization = Http::get("https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6");

        $send_notification = Http::get("https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04");

        if($new_value_payer != 1 or $new_value_payee != 1 or $external_authorization['message'] != "Autorizado"){
            DB::rollBack();
            return response()->json(['Erro' => 'Houve um erro na transação.'], 400);
        }
        $transaction_result = $this->transactionRepository->create($request);
        DB::commit();
        return $transaction_result;

    }

    public function save($user)
    {
        $this->transactionRepository->save($user);
    }

    public function destroy(int $id)
    {
        $this->transactionRepository->destroy($id);
    }

}
