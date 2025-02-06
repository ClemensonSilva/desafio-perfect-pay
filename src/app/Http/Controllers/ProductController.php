<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductServices;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  // correcao de bug que faz com que usuario submita formularios multiplas vezes
  // cadastro de produto
    private ProductServices $productService;
    public function __construct(ProductServices $productServices)
    {
        $this->productService = $productServices;
    }

    public function create(Request $request)
  {
    $this->productService->createProductServices($request);
    return redirect('/products')->with(['message' => 'roduto cadastrado com sucesso!']);
  }
    public function showProduct(Product $product)
    {
        $product = $this->productService->showProductsServices($product);
        return view('edit_product', compact('product'));
    }
  public function showSales()
  {
    $products = $this->productService->getAllProductServices();
    $clients = $this->productService->showSalesClientsServices();
    return view('crud_sales', compact('products', 'clients'));
  }
//PRECISO VOLTAR AQUI PARA CORRIGIR O get_sales_data()
  public function showDashboard()
  {
    $controllerSale = new Sales();
    $products = $this->productService->getAllProductServices();
    $clients = $this->productService->showSalesClientsServices();
    $sales = ($controllerSale->get_sales_data());
    return view('dashboard', compact('products', 'sales', 'clients'));
  }

  public function edit( int $id, Request $request)
  {
    $this->productService->editProductServices( $id,  $request);
    return redirect('/')->with(['message' =>  'Produto atualizado com sucesso!']);
  }
  public function delete(Product $product)
  {
    $this->productService->deleteProductService($product);
    return redirect('/');
  }
  function get_product_data(int $id ):string
  {
   return $this->productService->getProductServices($id);
  }
  function get_all_product_data():string
  {
        return $this->productService->getAllProductServices();
  }
}
