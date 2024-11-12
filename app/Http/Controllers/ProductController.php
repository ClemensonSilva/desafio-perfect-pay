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
    public function create(Request $request){
        $input = $request->validate(
           [ 
            'name' =>   'required|max:20',
            'description' =>   'required|max:55',
            'price' =>   'required',// é necessario correcao aqui para impedir que usuarios digitem valors com ',' separando as casas decimasi
           ]
        );

        $input[ 'name']= strip_tags( $input[ 'name'])  ;
        $input[ 'description']= strip_tags( $input[ 'description'])  ;
        $input[ 'price']= strip_tags( $input[ 'price'])  ;

        Product::create($input);
        return redirect('/products')->with(['message' => 'roduto cadastrado com sucesso!']);
      }

      public function showSales(){
        $products = get_products_data();
        $clients = json_encode(DB::table('client')->paginate(10));
        return view('crud_sales', compact('products', 'clients' ));
}     

      public function showDashboard(){
        $products = $this->get_products_data();
        $clients = json_encode(DB::table('client')->orderBy('name')->get());
        $controller = new Sales();
        $sales = json_encode($controller->get_sales_data()->forPage(1,10));
        return view('dashboard', compact('products','sales', 'clients' ));
      }

     public function showProduct(Product $product){
      $product = json_encode($product);
      return view('edit_product', compact('product'));
     }

      public function edit(Product $product, Request $request){
        $input = $request->validate(
          [ 
           'name' =>   'required|max:20',
           'description' =>   'required|max:55',
           'price' =>   'required',
          ]
       );

       $product['name'] = $input['name'];
       $product['description'] = $input['description'];
       $product['price'] = $input['price'];

       $product->update($input);
       return redirect('/')->with(['message' =>  'Produto atualizado com sucesso!']);
      }
      
      public function delete(Product $product){
        $product->delete();
        return redirect('/');
      }
      
function get_products_data($id=false)
{
  if($id){
    $products = Cache::remember('products-dashboard', 60*60, function($id){
            return DB::table('products')->where('id', $id)->get();
        });
    }else{
        $products = Cache::remember('products-dashboard', 60*60, function(){
           return DB::table('products')->orderBy('name')->paginate(10);
        });
    }
    return $products;
}
      
}
