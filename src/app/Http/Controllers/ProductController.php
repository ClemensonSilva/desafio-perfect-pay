<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
  // correcao de bug que faz com que usuario submita formularios multiplas vezes
  // cadastro de produto
  public function create(Request $request)
  {
    $input = $request->validate(
      [
        'name' =>   'required|max:20',
        'description' =>   'required|max:55',
        'price' =>   'required', // é necessario correcao aqui para impedir que usuarios digitem valors com ',' separando as casas decimasi
      ]
    );

    $input['name'] = strip_tags($input['name']);
    $input['description'] = strip_tags($input['description']);
    $input['price'] = strip_tags($input['price']);

    Product::create($input);
    return redirect('/products')->with(['message' => 'roduto cadastrado com sucesso!']);
  }

  public function showSales()
  {
    $products = $this->get_products_data();
    $controllerClient = new ClientController();
    $clients = json_encode($controllerClient->getClients());
    return view('crud_sales', compact('products', 'clients'));
  }

  public function showDashboard()
  {
    $controllerSale = new Sales();
    $controllerClient = new ClientController();
    $products = $this->get_products_data();
    $clients = $controllerClient->getClients();
    $sales = ($controllerSale->get_sales_data());
    return view('dashboard', compact('products', 'sales', 'clients'));
  }

  public function showProduct(Product $product)
  {
    $product = json_encode($product);
    return view('edit_product', compact('product'));
  }

  public function edit( $id, Request $request)
  {
    $input = $request->validate(
      [
        'name' =>   'required|max:20',
        'description' =>   'required|max:55',
        'price' =>   'required',
      ]
    );

    $productName = $input['name'];
    $productDescription = $input['description'];
    $productPrice = $input['price'];
    DB::table('products')->where('id', $id->id)->update(['name'=> $productName, 'description' => $productDescription, 'price'=> $productPrice]);
    Cache::forget('products-dashboard');
    return redirect('/')->with(['message' =>  'Produto atualizado com sucesso!']);
  }
// APLICAR SOFTDELTE NOS PRODUTOS
  public function delete(Product $product)
  {
    $product->delete();
    Cache::forget('products-dashboard');
    return redirect('/');
  }

  function get_products_data($id = false)
  {
    if ($id) {
      $products = Cache::remember('products-dashboard', 60 * 60, function () use ($id){
        return DB::select("select * from products where id = {$id}");
      });
    } else {
      $products = Cache::remember('products-dashboard', 60 * 60, function () {
        return DB::select('select * from products LIMIT 10 OFFSET 0');
      });
    }
    return json_encode($products);
  }
}
