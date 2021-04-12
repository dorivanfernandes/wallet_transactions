<?php


namespace App\Repository\Interfaces;


use App\Models\User;

interface IUserRepository
{
    public function all();

    public function find(int $id);

    public function create($user);

    public function save(User $user);

    public function destroy(int $id);

    public function subtractWalletValue(int $id, float $value);

    public function getWalletAmount(int $id);

    public function sumWalletValue(int $id, float $value);

    public function findByEmail(String $email);

}
