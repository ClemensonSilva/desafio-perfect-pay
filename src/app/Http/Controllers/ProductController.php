<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductServices;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductServices $productService;

    public function __construct(ProductServices $productServices)
    {
        $this->productService = $productServices;
    }

    public function create(Request $request)
    {
        $this->productService->createProductServices($request);
        return redirect('/products')->with(['message' => 'Produto cadastrado com sucesso!']);
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

    public function showDashboard()
    {
        $products = $this->productService->getAllProductServices();
        $clients = $this->productService->showSalesClientsServices();
        $sales = $this->productService->getSalesServices();
        return view('dashboard', compact('products', 'sales', 'clients'));
    }

    public function edit(int $id, Request $request)
    {
        $this->productService->editProductServices($id, $request);
        return redirect('/')->with(['message' => 'Produto atualizado com sucesso!']);
    }

    public function delete(Product $product)
    {
        $this->productService->deleteProductService($product);
        return redirect('/')->with(['message' => 'Produto deletado com sucesso!']);
    }

    function get_product_data(int $id): string
    {
        return $this->productService->getProductServices($id);
    }

    function get_all_product_data(): string
    {
        return $this->productService->getAllProductServices();
    }

    public function topSalledProducts()
    {
        return $this->productService->topSalledProductsRepository();
    }
}
