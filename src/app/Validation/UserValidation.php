<?php

namespace App\Validation;

use Illuminate\Http\Request;

class UserValidation
{
    private array $required;
    private array $unique;
    public function __construct()
    {
        $this->required =  ['required'=> "Você deve preencher o  :attribute"];
        $this->unique = ['unique' => "Já existe um usuário cadastrado com este :attribute"];
    }
    public function validateUser(Request $request): array
    {
        $input = $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ],  $this->required);
        $input['email'] = strip_tags($input['email']);
        $input['password'] = strip_tags($input['password']);
        return $input;
    }
    public function validateCadastro(Request $request): array
    {
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:client',
            'password' => 'required|min:8',
            'role_id' => 'required',
            'joined_date' => 'required',
        ], $this->required, $this->unique);

        $input['email'] = strip_tags($input['email']);
        $input['password'] = strip_tags($input['password']);
        $input['email'] = strip_tags($input['email']);
        $input['role_id'] = strip_tags($input['role_id']);
        $input['password'] = $this->crypted($input['password']);

        return $input;
    }
   public function crypted($password):false|null|string
   {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password, $stringHash){
        return password_verify($password, $stringHash);
    }

}
