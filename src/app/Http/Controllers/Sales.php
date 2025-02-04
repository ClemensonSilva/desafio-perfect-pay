<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\json_decode;

class Sales extends Controller
{
    public function create(Request $request)
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
        $date = strip_tags($inputForm["date"]);
        $quantity = strip_tags($inputForm["quantity"]);
        $discount = strip_tags($inputForm["discount"]);
        $status = strip_tags($inputForm["status"]);
        $salesPerson = strip_tags($inputForm["salesPerson"]);

        $product = Product::find($inputForm["product_id"]);
        $discount = validandoDesconto($product->price, $discount);
        $price_sales = salesPrice($quantity, $discount, $product->price);

        // manipulando o formato da data antes de inserir no db para mais dúvidas, verifique a doc do PHP sobre
        //a classe DateTime
        $dateFormat = aplicacao_banco_de_dados_($date);

        $client = Client::find($inputForm["client_id"]);
        $product->clients()->attach($client->id, [
            "quantity" => $quantity,
            "salesperson_id" => $salesPerson,
            "date" => $dateFormat,
            "discount" => $discount,
            "price_sales" => $price_sales,
            "status" => $status,
        ]);
        return redirect("/sales")->with("sucess", "Edicao feita com sucesso!");
    }
    public function dataToEditSales($id)
    {
        $controllerProduct = new ProductController();
        $products = $controllerProduct->get_products_data();

        $sale = $this->get_sales_data($id);
        return view("edit_sales", compact("sale", "products")); // parei aqui
    }
    public function editSale(Request $request, $id)
    {
        $inputForm = $request->validate([
            "client_id" => "required",
            "product_id" => "required|",
            "date" => "required",
            "quantity" => "required",
            "discount" => "required",
            "status" => "required",
        ]);

        $product_id = strip_tags($inputForm["product_id"]);
        $date = strip_tags($inputForm["date"]);
        $quantity = strip_tags($inputForm["quantity"]);
        $discount = strip_tags($inputForm["discount"]);
        $status = strip_tags($inputForm["status"]);

        $dateFormat = aplicacao_banco_de_dados_($date);

        $product = Product::find($product_id);
        $discount = validandoDesconto($product->price, $discount);
        $price_sales = salesPrice($quantity, $discount, $product->price);
        DB::table("client_products")
            ->where("id", $id)
            ->update([
                "product_id" => $product_id,
                "date" => $dateFormat,
                "quantity" => $quantity,
                "discount" => $discount,
                "price_sales" => $price_sales,
                "status" => $status,
            ]);

        return redirect("/")->with(["message" => "Edicao feita com sucesso!"]);
    }
    function getClientNames(Request $request)
    {
        $clientController = new ClientController();
        $inputForm = $request->validate(["search" => "required"]);
        $client = $clientController->searchClient($inputForm["search"]);
        return $client;
    }
    function lostCalculation(array $sales)
    {
         $lost = 0;
         $totalSales = 0;
        foreach($sales as $sale){
            $priceOfSale = $sale->price_sales;
            if($sale->status == "Devolvido" || $sale->status == "Cancelado"){
                $lost +=$priceOfSale;
            }else if($sale->status == "Aprovado"){
                $totalSales+=$priceOfSale;
            }
        }
        return json_encode(["losts"=>$lost, "totalSales"=>$totalSales]);
    }
    function mapStatusOfSales(array $sales){
        $aproved = 0;
        $canceled = 0;
        $returned = 0;

       foreach($sales as $sale){
           if($sale->status == "Cancelado"){
               $canceled +=1;
           }else if($sale->status == "Aprovado"){
               $aproved+=1;
           }else{
               $returned+=1;
           }
       }
       return json_encode(["aproved"=>$aproved, "returned"=>$returned, "canceled"=>$canceled]);

    }

    //LEMBRAR DE CRIAR JSON
    public function search(Request $request)
    {
        $producContoller = new ProductController();
        $inputForm = $request->validate(["search" => "required"]);
        $search = $inputForm["search"];
        $products = $producContoller->get_products_data();
        $sales = json_encode(
            $this->get_especific_sales_by_client_product($search)
        );

        return view("dashboard")
            ->with(compact("products", "sales"))
            ->with("message", "Resultados encontrados");
    }
    public function searchWithDate(Request $request)
    {
        try {
            $inputForm = $request->validate([
                "initialDate" => "required",
                "finalDate" => "required",
            ]);
            $initialDate = $inputForm["initialDate"];
            $finalDate = $inputForm["finalDate"];

            $initialDate = aplicacao_banco_de_dados_($initialDate);
            $finalDate = aplicacao_banco_de_dados_($finalDate);

            $producContoller = new ProductController();
            $products = $producContoller->get_products_data();
            $sales = $this->get_sales_betwen_dates($initialDate, $finalDate);
            $balanceOfSales = $this->lostCalculation(json_decode($sales));
            return view("dashboard", compact("products", "sales" , "balanceOfSales"))->with([
                "message" => "Resultados encontrados",
            ]);
        } catch (\Throwable $th) {
            return redirect("dashboard")->with([
                "message" => "Resultados não encontrados",
            ]);
        }
    }

    public function get_sales_data(int|bool $id = false, int $paginate = 7)
    {
        if ($id) {
            $sales = DB::select(
                'SELECT client_products.*, client.name as client_name,
        products.name as products_name, products.price as products_price FROM
        client_products  INNER JOIN client ON client_products.client_id = client.id
        INNER JOIN products ON client_products.product_id = products.id WHERE client_products.id = :id LIMIT 1',
                ["id" => $id]
            );
            $sales = $sales[0];
        } else {
            $sales = DB::select(
                'SELECT client_products.*, client.name as client_name,
         products.name as products_name, products.price as products_price FROM
         client_products INNER JOIN client ON client_products.client_id =  client.id
         INNER JOIN products ON client_products.product_id = products.id ORDER BY RAND() LIMIT :paginate OFFSET 0',
                ["paginate" => $paginate]
            );
        }
        return json_encode($sales);
    }
    function get_especific_sales_by_client_product(
        string $search,
        int $pagination = 15
    ) {
        $result = DB::select(
            "SELECT client_products.*, client.name as client_name,
         products.name as products_name, products.price as products_price FROM
         client_products INNER JOIN client ON client_products.client_id =  client.id
         INNER JOIN products ON client_products.product_id = products.id WHERE client.name like '%{$search}%' LIMIT :paginate OFFSET 0 ",
            ["paginate" => $pagination]
        );
        return $result;
    }

    function get_sales_betwen_dates($initialDate, $finalDate)
    {
        $sales = DB::select(
            "SELECT client_products.*, client.name as client_name,
    products.name as products_name, products.price as products_price FROM
    client_products INNER JOIN client ON client_products.client_id =  client.id
    INNER JOIN products ON client_products.product_id = products.id WHERE client_products.date between :initialDate AND :finalDate",
            ["initialDate" => $initialDate, "finalDate" => $finalDate]
        );
        return json_encode($sales);
    }
    function aplicacao_banco_de_dados_($date_from_app)
    {
        $format = "d/m/Y";
        $dateFormat = \DateTime::createFromFormat(
            $format,
            $date_from_app
        )->format("Y-m-d");
        return $dateFormat;
    }
    function banco_de_dados_aplicacao($date_from_db)
    {
        $format = "Y-m-d";
        $date_formated = \DateTime::createFromFormat(
            $format,
            $date_from_db
        )->format("d/m/Y");
        return $date_formated;
    }
    function validandoDesconto(float $productPrice, float $discount)
    {
        if ($discount >= $productPrice) {
            $discount = $productPrice * 0.1;
            return $discount;
        }
        return $discount;
    }
    function salesPrice(int $quantity, float $discount, float $priceProduct)
    {
        $salePrice = $quantity * $priceProduct - $discount;
        return $salePrice;
    }
}
