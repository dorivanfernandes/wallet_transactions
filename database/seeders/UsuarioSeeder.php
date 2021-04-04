<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'full_name' => 'wallet',
            'cpf_cnpj' => '99988877766',
            'email' => 'wallet@outlook.com',
            'password' => Hash::make('wallet'),
            'user_type' => '1',
            'wallet_balance' => '0.00'
        ]);
    }
}
