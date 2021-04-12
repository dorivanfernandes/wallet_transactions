<?php


namespace App\Http\Controllers;


use App\Models\User;
use App\Services\TokenService;
use Firebase\JWT\JWT;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \Exception;

class TokenController extends Controller
{

    private $tokenService;

    public function __construct(TokenService $token)
    {
        $this->tokenService = $token;
    }

    public function login(Request $request)
    {
        try {
            return response()->json($this->tokenService->login($request));
        }catch (Exception $e){
            return response()->json(['Error' => $e->getMessage()], $e->getCode());
        }

    }

}
