<?php

namespace App\Validation;

use Illuminate\Http\Request;

class SalesValidation
{
    public function validateSales(Request $request): array
    {
        $inputForm = $request->validate([
            "client_id" => "required",
            "product_id" => "required",
            "salesPerson" => "required",
            "date" => "required",
            "quantity" => "required",
            "discount" => "required",
            "status" => "required",
        ]);

        $inputForm["client_id"] = strip_tags($inputForm["client_id"]);
        $inputForm["product_id"] = strip_tags($inputForm["product_id"]);
        $inputForm["salesPerson"] = strip_tags($inputForm["salesPerson"]);
        $inputForm["date"] = $this->applicationToDbServices(strip_tags($inputForm["date"]));
        $inputForm["quantity"] = strip_tags($inputForm["quantity"]);
        $inputForm["discount"] = strip_tags($inputForm["discount"]);
        $inputForm["status"] = strip_tags($inputForm["status"]);
        return $inputForm;

    }
    public function validateUpdate(Request $request): array
    {
        $inputForm = $request->validate([
            "client_id" => "required",
            "product_id" => "required|",
            "date" => "required",
            "quantity" => "required",
            "discount" => "required",
            "status" => "required",
        ]);

        $inputForm["client_id"] = strip_tags($inputForm["client_id"]);
        $inputForm["product_id"] = strip_tags($inputForm["product_id"]);
        $inputForm["date"] = $this->applicationToDbServices(strip_tags($inputForm["date"]));
        $inputForm["quantity"] = strip_tags($inputForm["quantity"]);
        $inputForm["discount"] = strip_tags($inputForm["discount"]);
        $inputForm["status"] = strip_tags($inputForm["status"]);
        return $inputForm;
    }

    public function validateSearch(Request $request): string{
        $inputForm = $request->validate(["search" => "required"]);
        $inputForm["search"] = strip_tags($inputForm["search"]);
        return $inputForm['search'];
    }
    public function validateDateSearch(Request $request): array
    {
         $inputForm = $request->validate([
            "initialDate" => "required",
            "finalDate" => "required",
        ]);
         $inputForm["initialDate"] = aplicacao_banco_de_dados_($inputForm["initialDate"]);
         $inputForm["finalDate"] = aplicacao_banco_de_dados_($inputForm["finalDate"]);
         return $inputForm;
    }

    public function validateDiscountService(float $productPrice, float $discount): float
    {
        if ($discount >= $productPrice) {
            return ($productPrice * 0.1);
        }
        return $discount;
    }
    public function salesPriceServices(int $quantity, float $discount, float $productPrice):int
    {
        return $quantity * $productPrice - $discount;
    }
    public function applicationToDbServices($date_from_app):string|false
    {
        $format = "d/m/Y";
        return \DateTime::createFromFormat(
            $format,
            $date_from_app
        )->format("Y-m-d");
    }

    public function dbToApplicationServices($date_from_db):string|false
    {
        $format = "Y-m-d";
        return \DateTime::createFromFormat(
            $format,
            $date_from_db
        )->format("d/m/Y");
    }
}
