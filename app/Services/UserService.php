<?php


namespace App\Services;

use App\Models\User;
use App\Repository\Interfaces\IUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use LogicException;

class UserService
{
    protected $userRepository;
    protected $validations = [
        'full_name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'cpf_cnpj' => 'required|unique:users',
        'password' => 'required|min:3',
        'user_type' => 'required'
    ];

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
        $recurso = $this->userRepository->find($id);
        if(is_null($recurso)){
            throw new LogicException("", 204);
        }
        return $recurso;
    }

    public function create($user)
    {
        $this->makeValidations($user, $this->validations);
        $user["password"] = Hash::make($user["password"]);

        return $this->userRepository->create($user);
    }

    public function save(int $id, Request $request)
    {
        $recurso = $this->userRepository->find($id);

        if(is_null($recurso)){
            throw new LogicException('Recurso não encontrado', 404);
        }

        $recurso->fill($request->all());

        $this->userRepository->save($recurso);

        return $recurso;

    }

    public function destroy(int $id)
    {
        $qtdRemoved = $this->userRepository->destroy($id);

        if($qtdRemoved === 0 ){
            throw new LogicException('Recurso não encontrado', 404);
        }

    }

    public function findByEmail(String $email)
    {
        $this->userRepository->findByEmail($email);
    }

    private function makeValidations($data, $validations_rules){
        $validation = Validator::make($data, $validations_rules);

        if($validation->fails()){
            throw new InvalidArgumentException($validation->errors()->first(), 400);
        }
    }
}
