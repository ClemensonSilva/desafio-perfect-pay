<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\Product;
use App\Validation\SalesValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesRepository
{
    private SalesValidation $salesValidation;
    private ClientRepository $clientRepository;

    public function __construct(SalesValidation $salesValidation, ClientRepository $clientRepository)
    {
        $this->salesValidation = $salesValidation;
        $this->clientRepository = $clientRepository;
    }
    public function createSaleRepository(Request $request):void
    {
        $input = $this->salesValidation->validateSales($request);
        $product = $this->getProductRepository($input['product_id']);
        $input['discount'] = $this->salesValidation->validateDiscountService($product->price,$input['discount']);
        $input['salesPrice'] = $this->salesValidation->salesPriceServices(
            $input['quantity'],$input['discount'],$product->price);
        $this->createSale($product, $input);
    }
    public function createSale(Product $product, array $input):void
    {
        $client = Client::find($input["client_id"]);
        $product->clients()->attach($client->id, [
            "quantity" => $input['quantity' ],
            "salesperson_id" => $input['salesPerson' ],
            "date" => $input['date' ],
            "discount" => $input['discount' ],
            "price_sales" => $input['salesPrice' ],
            "status" => $input['status' ],
        ]);
    }
    public function editSaleRepository(Request $request, int $id)
    {
        try {
            $input = $this->salesValidation->validateUpdate($request);
            $product = $this->getProductRepository($input['product_id']);
            $input['discount'] = $this->salesValidation->validateDiscountService($product->price,$input['discount']);
            $input['salesPrice'] = $this->salesValidation->salesPriceServices(
                $input['quantity'],$input['discount'],$product->price);
            $this->updateSaleRepository($input, $id);

        }catch (\Exception $e){
            return json_encode(["error"=> "true", "message"=>$e->getMessage()]);
        }
       }
    public function updateSaleRepository(array $input, int $id):void
    {
        DB::table("client_products")
            ->where("id", $id)
            ->update([
                "product_id" => $input['product_id'],
                "date" => $input['date'],
                "quantity" =>  $input['quantity'],
                "discount" => $input[ 'discount' ],
                "price_sales" => $input['salesPrice'],
                "status" => $input['status'],
            ]);
    }
    public function getProductRepository(int $id):Product
    {
        return Product::find($id);
    }
    public function searchWithDateRepository(Request $request):string
    {
         $input = $this->salesValidation->validateDateSearch($request);
         return $this->getSalesBetwenDatesRepository($input['initialDate'], $input['finalDate']);
    }
    public function getSalesBetwenDatesRepository($initialDate, $finalDate):string
    {
        return json_encode(DB::select(
            "SELECT client_products.*, client.name as client_name,
    products.name as products_name, products.price as products_price FROM
    client_products INNER JOIN client ON client_products.client_id =  client.id
    INNER JOIN products ON client_products.product_id = products.id WHERE client_products.date between :initialDate AND :finalDate",
            ["initialDate" => $initialDate, "finalDate" => $finalDate]
        ));
    }
    public function getClientNamesRepository(Request $request):string
    {
        $inputValidated = $this->salesValidation->validateSearch($request);

        return $this->clientRepository->searchClient($inputValidated);
    }
    public function getSaleRepository(int $id):string
    {
        $sales = DB::select(
            'SELECT client_products.*, client.name as client_name,
        products.name as products_name, products.price as products_price FROM
        client_products  INNER JOIN client ON client_products.client_id = client.id
        INNER JOIN products ON client_products.product_id = products.id WHERE client_products.id = :id LIMIT 1',
            ["id" => $id]
        );
        return json_encode( $sales[0]);
    }
    public function getSalesByClientRepository(Request $request, int $paginate = 7):string
    {
        $search = $this->salesValidation->validateSearch($request);

        return  json_encode(DB::select(
            "SELECT client_products.*, client.name as client_name,
         products.name as products_name, products.price as products_price FROM
         client_products INNER JOIN client ON client_products.client_id =  client.id
         INNER JOIN products ON client_products.product_id = products.id WHERE client.name like '%{$search}%' LIMIT :paginate OFFSET 0 ",
            ["paginate" => $paginate]
        ));
    }
    public function getSalesRepository(int $paginate = 7):string
    {
        return json_encode(DB::select(
            'SELECT client_products.*, client.name as client_name,
         products.name as products_name, products.price as products_price FROM
         client_products INNER JOIN client ON client_products.client_id =  client.id
         INNER JOIN products ON client_products.product_id = products.id ORDER BY RAND() LIMIT :paginate OFFSET 0',
            ["paginate" => $paginate]
        ));
    }
}
