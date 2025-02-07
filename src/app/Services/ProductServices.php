<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\SalesRepository;
use Illuminate\Http\Request;

class ProductServices
{
    private ProductRepository $productRepository;
    private ClientServices $clientServices;
    // NAO DEVIA HAVER CJAMADA DE SERVICOS AQ DENTRO
    private SalesRepository $salesRepository;
    public function __construct(ProductRepository $productRepository,  ClientServices $clientServices, SalesRepository $salesRepository)
    {
        $this->productRepository = $productRepository;
        $this->clientServices = $clientServices;
        $this->salesRepository = $salesRepository;
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
    public function getSalesServices()
    {
        return $this->salesRepository->getSalesRepository();
    }

}
