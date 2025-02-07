<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
// guardar data no DB
function aplicacao_banco_de_dados_($date_from_app)
{
    $format = 'd/m/Y';
    $dateFormat = \DateTime::createFromFormat($format, $date_from_app)->format('Y-m-d');
    return $dateFormat;
};
// converter data do DB
function banco_de_dados_aplicacao($date_from_db)
{
    $format = 'Y-m-d';
    $date_formated = \DateTime::createFromFormat($format, $date_from_db)->format('d/m/Y');
    return $date_formated;
}






function validandoDesconto($productPrice, $discount){
    if($discount >= $productPrice ){
         $discount = $productPrice*0.1;
         return $discount;
    }
    return $discount;
};
function salesPrice($quantity, $discount, $priceProduct){
    $salePrice = ($quantity*$priceProduct)-$discount;
    return  $salePrice;
}

function crypted($password){
    return password_hash($password, PASSWORD_DEFAULT);
}
function verifyPassword($password, $stringHash){
    return password_verify($password, $stringHash);
}
function discount_based_history_client() {}
