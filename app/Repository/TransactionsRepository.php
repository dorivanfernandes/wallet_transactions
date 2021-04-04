<?php


namespace App\Repository;


use App\Models\Transactions;
use App\Repository\Interfaces\ITransactionsRepository;

class TransactionsRepository implements ITransactionsRepository
{

    public function create($transaction)
    {
        return Transactions::create($transaction);
    }
}
