<?php


namespace App\Http\Controllers;


use App\Models\Transactions;
use App\Models\User;
use App\Services\TransactionsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionsController extends BaseController
{
    public function __construct(TransactionsService $transactionsService)
    {
        $this->service = $transactionsService;
        $this->validations = [
            'user_payer' => 'required|exists:users,id',
            'user_payee' => 'required|exists:users,id',
            'transaction_value' => 'required|gt:0'
        ];
    }


}
