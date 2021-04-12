<?php


namespace App\Http\Controllers;


use App\Models\User;
use App\Repository\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserController extends BaseController
{

    public function __construct(UserService $userService)
    {
        $this->service = $userService;

    }

}
