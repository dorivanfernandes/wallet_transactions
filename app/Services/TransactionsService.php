<?php


namespace App\Services;


use App\Models\User;
use App\Repository\Interfaces\ITransactionsRepository;
use App\Repository\Interfaces\IUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use LogicException;

class TransactionsService
{
    protected $transactionRepository;
    protected $userRepository;
    protected $validations = [
        'user_payer' => 'required|exists:users,id',
        'user_payee' => 'required|exists:users,id',
        'transaction_value' => 'required|gt:0'
    ];

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
        $this->makeValidations($request, $this->validations, $user, $wallet_balance_payer);

        DB::beginTransaction();
        $wallet_balance_payer -= floatval($request['transaction_value']);
        $new_value_payer = $this->userRepository->subtractWalletValue($user->id, $wallet_balance_payer);

        $wallet_balance_payee = floatval($this->userRepository->getWalletAmount(intval($request['user_payee'])));
        $wallet_balance_payee += floatval($request['transaction_value']);
        $new_value_payee = $this->userRepository->sumWalletValue(intval($request['user_payee']), $wallet_balance_payee);

        $external_authorization = Http::get("https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6");


        if($new_value_payer != 1 or $new_value_payee != 1 or $external_authorization['message'] != "Autorizado"){
            DB::rollBack();
            throw new LogicException('There was an error in the transaction.', 400);
        }
        $transaction_result = $this->transactionRepository->create($request);
        DB::commit();
        $send_notification = Http::get("https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04");
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

    private function makeValidations($data, $validations_rules, $user, $wallet_balance_payer){
        $validation = Validator::make($data, $validations_rules);

        if($validation->fails()){
            throw new InvalidArgumentException($validation->errors()->first(), 400);
        }

        if($user->user_type == 2){
            throw new LogicException('Lojistas are not authorized to make transactions.', 401);
        }

        if($user->id != $data['user_payer']){
            throw new LogicException('The logged user is not the payer user. They must be the same.', 400);
        }

        if($user->id == $data['user_payee']){
            throw new LogicException('The payer user and the payee user must be diferent.', 400);
        }

        if($wallet_balance_payer < $data['transaction_value']){
            throw new LogicException('The wallet balance is insufficient to make this transaction.', 400);
        }
    }

}
