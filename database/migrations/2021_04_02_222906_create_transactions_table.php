<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_payer")->unsigned();
            $table->bigInteger("user_payee")->unsigned();
            $table->float("transaction_value");
            $table->timestamps();

            $table->foreign("user_payer")->references("id")->on('users');
            $table->foreign("user_payee")->references("id")->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
