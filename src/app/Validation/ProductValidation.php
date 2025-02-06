<?php

namespace App\Validation;

use App\Models\Product;
use http\Env\Request;

class ProductValidation
{
    public function validateProduct(Request $request):array{
        $input = $request->validate(
            [
                'name' =>   'required|max:20',
                'description' =>   'required|max:55',
                'price' =>   'required', // é necessario correcao aqui para impedir que usuarios digitem valors com ',' separando as casas decimasi
            ]
        );

        $input['name'] = strip_tags($input['name']);
        $input['description'] = strip_tags($input['description']);
        $input['price'] = strip_tags($input['price']);
        return $input;
    }

}
