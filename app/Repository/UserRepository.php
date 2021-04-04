<?php


namespace App\Repository;


use App\Models\User;
use App\Repository\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{

    public function all()
    {
        return User::all();
    }

    public function find(int $id)
    {
        return User::find($id);
    }

    public function create($user)
    {
        return User::create($user);
    }

    public function save($user)
    {
        return $user->save();
    }

    public function destroy(int $id)
    {
        return User::destroy($id);
    }

    public function subtractWalletValue(int $id, float $value)
    {
        return User::where('id', $id)->update(array('wallet_balance' => $value));
    }

    public function getWalletAmount(int $id)
    {
        return User::where('id', $id)->first()->wallet_balance;
    }

    public function sumWalletValue(int $id, float $value)
    {
       return User::where('id', $id)->update(array('wallet_balance' => $value));
    }
}
