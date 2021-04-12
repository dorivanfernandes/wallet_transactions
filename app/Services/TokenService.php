<?php


namespace App\Services;


use App\Repository\Interfaces\IUserRepository;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;


class TokenService
{
    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        if($validations->fails()){
            throw new InvalidArgumentException($validations->errors()->first(), 400);
        }

        $user_exist = $this->userRepository->findByEmail($request->email);

        if(is_null($user_exist) || !Hash::check($request->password, $user_exist->password)){
            throw new InvalidArgumentException('E-mail or password is invalid', 401);
        }

        $token = JWT::encode(['email' => $request->email], env('JWT_KEY'));

        return ['access_token' => $token];

    }
}
