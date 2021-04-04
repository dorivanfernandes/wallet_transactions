<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class InsertUserType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::create([
            'type_name' => 'comum'
        ]);
        UserType::create([
            'type_name' => 'lojista'
        ]);
    }
}
