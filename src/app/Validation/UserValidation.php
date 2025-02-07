<?php

namespace App\Validation;

use Illuminate\Http\Request;

class UserValidation
{
    public function validateUser(Request $request): array
    {
        $input = $request->validate([
            'email' => 'required|unique:client',
            'password' => 'required|min:8',
        ]);
        $input['email'] = strip_tags($input['email']);
        $input['password'] = strip_tags($input['password']);
        return $input;
    }
    public function validateCadastro(Request $request): array
    {
        $input = $request->validate([
            'email' => 'required|unique:client',
            'password' => 'required|min:8',
            'role_id' => 'required',
            'name' => 'required',
        ]);

        $input['email'] = strip_tags($input['email']);
        $input['password'] = strip_tags($input['password']);
        $input['email'] = strip_tags($input['email']);
        $input['role_id'] = strip_tags($input['role_id']);
        $input['password'] = $this->crypted($input['password']);

        return $input;
    }
   public function crypted($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password, $stringHash){
        return password_verify($password, $stringHash);
    }

}
