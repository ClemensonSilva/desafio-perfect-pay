<?php

namespace Database\Seeders;

use App\Http\Controllers\Sales;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Product;
use App\Models\Users;
use Illuminate\Support\Facades\DB;

class ClientsProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Product::all( ) as $product){
            $client = rand(1, Client::count());
            $salesPerson = rand(1, Users::count());

            $discount =  validandoDesconto($product['price'], fake()->numerify('##'));
            $quantity = fake()->numerify('#');
            $sales_price = salesPrice($quantity,$discount,$product['price']);
            $product->clients()->attach($client, [
                'salesperson_id'=>$salesPerson, 
                'quantity' => $quantity, 
                'date' => fake()->date('Y_m_d') ,
                'discount' => $discount, 
                'price_sales' => $sales_price, 
                'status' => fake()->randomElement(['Aprovado', 'Cancelado', 'Devolvido'])]);
        };
    }

}
