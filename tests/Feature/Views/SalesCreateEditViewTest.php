<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Sales;
use App\Models\Client;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

# php artisan test --filter=SalesViewTest
class SalesViewTest extends TestCase
{

    use RefreshDatabase;

    // teste para ver se os produtos estao sendo enviados para a view edit_sales
    public function test_create_sales_are_showed_only_for_loggeds_corretly()
    {
        $user = Users::factory(1)->create()->first();
        $this->actingAs($user)->withSession(['user_id' => '1']);
        $response = $this->get('/sales');
        $response->assertViewIs('crud_sales');
        $response->assertStatus(200);
    }
    public function test_edit_sales_are_showed_only_for_admins_corretly()
    {

        // criando uma venda
        $client = Client::factory(1)->create()->first();
        $product = Product::factory(1)->create()->first();
        $admin = Users::factory(1)->create()->first();
        $this->actingAs($admin)->withSession(['user_id' => '1', 'role_id' => '1']);
        //metodo ja testado
        $request = Request::create('/sales', 'POST', [
            'client_id' =>   $client->id,
            'product_id' =>   $product->id,
            'date' =>   '29/09/2024',
            'quantity' =>   '3',
            'discount' =>   '20',
            'status' =>   'Aprovado',
        ]);
        $sale = new Sales();
        $sale->create($request); // o id dessa venda sera 1
        $saleId = json_decode($sale->get_sales_data(1))->id;
        $response = $this->get(route('sales.edit', ['sale' => $saleId]));
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function test_edit_sales_are_not_showed_for_not_admins_corretly()
    {
        $user = Users::factory(1)->create()->first();
        $this->actingAs($user)->withSession(['user_id' => '1', 'role_id' => '2']);
      
        $sale = new Sales();
        $saleId = json_decode($sale->get_sales_data(1))->id;
        $response = $this->get(route('sales.edit', ['sale' => $saleId]));
        $response->assertStatus(302);
    }


    // teste para
    // teste para
    // teste para
    // teste para



}
