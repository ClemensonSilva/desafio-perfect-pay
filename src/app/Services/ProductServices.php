<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductServices
{
    private ProductRepository $productRepository;
    private ClientServices $clientServices;
    public function __construct(ProductRepository $productRepository,  ClientServices $clientServices)
    {
        $this->productRepository = $productRepository;
        $this->clientServices = $clientServices;
    }
    public function createProductServices(Request $request):void{
         $this->productRepository->createProductRepository($request);
    }
    public function showProductsServices(Product $product):string{
        return json_encode($product);
    }
    public function editProductServices(int $id,Request $request):void
    {
        $this->productRepository->editProductRepository( $id, $request);
    }
    public function deleteProductService(Product $product):void
    {
        $this->productRepository->deleteProductRepository($product);
    }//VOU TER QUE PRCURAR AS APPLICACOES DESSA FUNCAO
    public function getProductServices(int $id):string
    {
          return $this->productRepository->getProductRepository($id);
    }
    public function getAllProductServices():string
    {
        return  $this->productRepository->getAllProductsRepository();
    }
    public function showSalesClientsServices():string
    {
         return  json_encode($this->clientServices->getClients());
    }

}
