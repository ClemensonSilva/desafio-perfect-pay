<?php

namespace App\Validation;
use Illuminate\Http\Request as Request;

class ClientValidation
{
    public static function validateClient(Request $request): array
    {
         $inputForm = $request->validate([
            'name'=> 'required',
            'email'=> 'required|unique:client',
            'cpf'=> 'required|unique:client|max:15',
        ]);
        $inputForm['name'] = strip_tags($inputForm['name'] );
        $inputForm['email'] = strip_tags($inputForm['email'] );
        $inputForm['cpf'] = strip_tags($inputForm['cpf'] );

        return $inputForm;
    }
}
