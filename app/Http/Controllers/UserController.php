<?php


namespace App\Http\Controllers;


use App\Models\User;
use App\Repository\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
        $this->validations = [
            'email' => 'required|email|unique:users',
            'cpf_cnpj' => 'required|unique:users',
            'password' => 'required|min:3',
        ];
    }


    public function store(Request $request)
    {
        if(!is_null($this->validations)){
            $this->validate($request, $this->validations);
        }

        return response()
            ->json($this->service->create([
                "full_name" => $request->full_name,
                "cpf_cnpj" => $request->cpf_cnpj,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "user_type" => $request->user_type,
            ]), 201);
    }



}
