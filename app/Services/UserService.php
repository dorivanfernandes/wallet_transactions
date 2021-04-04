<?php


namespace App\Services;

use App\Models\User;
use App\Repository\Interfaces\IUserRepository;
use Illuminate\Http\Request;

class UserService
{
    protected $userRepository;

    public function __construct(IUserRepository $user)
    {
        $this->userRepository = $user;
    }

    public function all()
    {
        return $this->userRepository->all();
    }

    public function find(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function create($user)
    {
        return $this->userRepository->create($user);
    }

    public function save($user)
    {
        $this->userRepository->save($user);
    }

    public function destroy(int $id)
    {
        $this->userRepository->destroy($id);
    }
}
