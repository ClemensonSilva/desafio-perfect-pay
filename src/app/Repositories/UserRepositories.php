<?php

namespace App\Repositories;

use App\Models\Users;
use App\Validation\UserValidation;
use Illuminate\Http\Request;

class UserRepositories
{
    private UserValidation $userValidation;
    public function __construct(UserValidation $userValidation)
    {
        $this->userValidation = $userValidation;
    }

public function findUser($email)
{
    return $user = Users::where('email', $email)->first();
}
public function createUserRepositories(Request $request):void
{
    $input = $this->userValidation->validateCadastro($request);
     Users::create($input);
}

}
