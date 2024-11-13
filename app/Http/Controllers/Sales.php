<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Sales extends Controller
{

    public function create(Request $request)
    {
        $inputForm = $request->validate(
            [
                'client_id' =>   'required',
                'product_id' =>   'required',
                'date' =>   'required',
                'quantity' =>   'required',
                'discount' =>   'required',
                'status' =>   'required',
            ]
        );

        $inputForm['client_id'] = strip_tags($inputForm['client_id']);
        $inputForm['product_id'] = strip_tags($inputForm['product_id']);
        $date = strip_tags($inputForm['date']);
        $quantity = strip_tags($inputForm['quantity']);
        $discount = strip_tags($inputForm['discount']);
        $status = strip_tags($inputForm['status']);
        $product = Product::find($inputForm['product_id']);
        $discount = validandoDesconto( $product->price,$discount);
        $price_sales = salesPrice($quantity, $discount, $product->price);

        // manipulando o formato da data antes de inserir no db para mais dúvidas, verifique a doc do PHP sobre 
        //a classe DateTime
        $dateFormat = aplicacao_banco_de_dados_($date);

        $client = Client::find($inputForm['client_id']);
        $product->clients()->attach($client->id,
            [
                'quantity' => $quantity,
                'date' => $dateFormat,
                'discount' => $discount,
                'price_sales' => $price_sales,
                'status' => $status
            ]
        );
        return redirect('/sales')->with('sucess','Edicao feita com sucesso!');
    }
    public function dataToEditSales($id)
    {
        $products = json_encode(DB::table('products')->paginate(10));

        $sale = json_encode($this->get_sales_data($id));
        return view('edit_sales',compact( 'sale', 'products')); // parei aqui
    }
    public function editSale(Request $request, $id)
    {
        $inputForm = $request->validate(
            [
                'client_id' => 'required',
                'product_id' =>   'required|',
                'date' =>   'required',
                'quantity' =>   'required',
                'discount' =>   'required',
                'status' =>   'required',
            ]
        );

        $product_id = strip_tags($inputForm['product_id']);
        $date = strip_tags($inputForm['date']);
        $quantity = strip_tags($inputForm['quantity']);
        $discount = strip_tags($inputForm['discount']);
        $status = strip_tags($inputForm['status']);
        
        $dateFormat = aplicacao_banco_de_dados_($date);
        
        $product = Product::find($product_id);
        $discount = validandoDesconto( $product->price, $discount);
        $price_sales = salesPrice($quantity, $discount, $product->price);
        DB::table('client_products')->where('id', $id)->update(['product_id' => $product_id,
            'date' => $dateFormat,
            'quantity' => $quantity,
            'discount' => $discount,
            'price_sales' => $price_sales,
            'status' => $status]);

        return redirect('/')->with(['message','Edicao feita com sucesso!']);
    }

    //LEMBRAR DE CRIAR JSON
    public function search(Request $request)
    {
        $inputForm = $request->validate(['search' => 'required']);
        $search = $inputForm['search'];
        $producContoller = new ProductController();
        $products = $producContoller->get_products_data();
        $sales = json_encode(get_especific_sales_by_client_product($search));

        return view('dashboard', compact('products','sales', ))->with(['message','Resultados encontrados']);
    }
    public function searchWithDate(Request $request)
    {
        $inputForm = $request->validate(['initialDate' => 'required', 'finalDate' => 'required']);
        $initialDate = $inputForm['initialDate'];
        $finalDate = $inputForm['finalDate'];

        $initialDate = aplicacao_banco_de_dados_($initialDate);
        $finalDate = aplicacao_banco_de_dados_($finalDate);

        $producContoller = new ProductController();
        $products = $producContoller->get_products_data();
        $sales = $this->get_sales_betwen_dates($initialDate, $finalDate);
        
        return view('dashboard', compact('products','sales', ))->with(['message','Resultados encontrados']);
    }

   public function get_sales_data($id = false, $paginate = 10)
{
    if ($id) {
        $sales =  DB::table('client_products')
            ->join('client', 'client_products.client_id', '=', 'client.id')
            ->join('products', 'client_products.product_id', '=', 'products.id')
            ->select(
                'client_products.*',
                'client.name as client_name',
                'products.name as products_name',
                'products.price as products_price'
            )
            ->where('client_products.id', '=',  $id)
            ->first();
    } else {
        $sales = DB::table('client_products')
            ->join('client', 'client_products.client_id', '=', 'client.id')
            ->join('products', 'client_products.product_id', '=', 'products.id')
            ->select('client_products.*', 'client.name as client_name', 'products.name as products_name', 'products.price as products_price')
            ->get();
    }
    return $sales;
}
function get_sales_betwen_dates($initialDate, $finalDate)
{
    $sales = DB::table('client_products')
        ->join('client', 'client_products.client_id', '=', 'client.id')
        ->join('products', 'client_products.product_id', '=', 'products.id')
        ->whereBetween('date', [$initialDate, $finalDate])
        ->select(
            'client_products.*',
            'client.name as client_name',
            'products.name as products_name',
            'products.price as products_price'
        )->get();
    return json_encode($sales);
}
function aplicacao_banco_de_dados_($date_from_app)
{
    $format = 'd/m/Y';
    $dateFormat = \DateTime::createFromFormat($format, $date_from_app)->format('Y-m-d');
    return $dateFormat;
}
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
}
function salesPrice($quantity, $discount, $priceProduct){
    $salePrice = ($quantity*$priceProduct)-$discount;
    return  $salePrice;
}

}
