<?php

namespace App\Services;

use App\Repositories\UserRepositories;
use App\Validation\UserValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class UserServices
{
    private UserRepositories $userRepositories;
    private UserValidation $userValidation;
    public function __construct(UserRepositories $userRepositories, UserValidation $userValidation)
    {
        $this->userRepositories = $userRepositories;
        $this->userValidation = $userValidation;
    }
    public function createServices(Request $request)
    {
        $this->userRepositories->createUserRepositories($request);
    }
    public function loginUserServices(Request $request)
    {
        $input = $this->userValidation->validateUser($request);
        $user = $this->userRepositories->findUser($input['email']);
        if($user){
            if($this->userValidation->verifyPassword($input['password'], $user->password)){
                Session::put('name', $user->name);
                Session::put('user_id', $user->id);
                Session::put('role_id', $user->role_id);
                return json_encode(["code"=> "200", "message"=> "Seja bem vindo!", "user"=> $user->name]);
            }
            else{
                return json_encode(["code"=> "401",'error'=> 'Senha incorreta.']); // retornar os dados do usuario logado
            }
        }else {
            return json_encode(['code'=>"404", 'error' =>'Usuario não encontrado. Por favor, peça para o admin cadastrá-lo.']);;
        }
    }

}
