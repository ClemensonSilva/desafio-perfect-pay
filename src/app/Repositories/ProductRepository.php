<?php

namespace App\Repositories;

use App\Models\Product;
use App\Validation\ProductValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductRepository

{
    private ProductValidation $productValidation;
    public function __construct(ProductValidation $productValidation){
        $this->productValidation = $productValidation;
    }
    public function createProductRepository(Request $request):void{
        $productData = $this->productValidation->productValidation($request);
        Product::create($productData);
    }
    public function editProductRepository(int $id,Request $request): void
    {
        $input = $this->productValidation->validateProduct($request);
        DB::table('products')->where('id', $id)->update(['name'=> $input['name'], 'description' => $input['description'], 'price'=> $input['price']]);
        Cache::forget('products-dashboard');

    }
    public function deleteProductRepository(Product $product):void
    {
        $product->delete();
        Cache::forget('products-dashboard');
    }
    public function getProductRepository(int $id):string{
        $products = Cache::remember('products-dashboard', 60 * 60, function () use ($id){
            return DB::select("select * from products where id = {$id}");
        });
        return json_encode($products);

    }
    public function getAllProductsRepository():string
    {
        $products = Cache::remember('products-dashboard', 60 * 60, function () {
            return DB::select('select * from products LIMIT 10 OFFSET 0');
        });
        return json_encode($products);
    }
}
