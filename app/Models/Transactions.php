<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = ['user_payer', 'user_payee', 'transaction_value'];
    protected $hidden = ['created_at', 'updated_at', 'id'];

}
