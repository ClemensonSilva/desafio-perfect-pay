<?php

namespace Tests\Feature;

use App\Http\Controllers\Sales;
use App\Models\Client;
use App\Models\Product;
use App\Models\Users;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;

# php artisan test --filter=SalesController
class SalesController extends TestCase
{
    use RefreshDatabase;
  /*   public function test_sales_are_searched_corretly(){
        Event::fake();
        $client = Client::factory(1)->create()->first();
        $product = Product::factory(1)->create()->first();
        $admin = Users::factory(1)->create()->first();
        $this->actingAs($admin)->withSession(['user_id' => '1', 'role_id' => '1']);
        

        $sale = new Sales();
        $request = Request::create('search', 'GET', [])
    } */
   protected $client;
   protected $product;
   protected $saleArray;
   protected $newSaleArray;

   public function setUp() :void{
    parent::setUp();
    $client = Client::factory(3)->create()->first();
    $product = Product::factory(2)->create()->first();
    $this->saleArray =  [
        'client_id' =>   $client->id,
        'product_id' =>   $product->id,
        'date' =>   '29/09/2024',
        'quantity' =>   '3',
        'discount' =>   '30',
        'status' =>   'Aprovado',
    ];
    $this->newSaleArray =  $this->saleArray;
    $this->newSaleArray['product_id'] = Product::query()->where('id', 2)->get()->toArray()[0]['id']; // quero apenas o id
    $this->newSaleArray['client_id'] = 2; // quero apenas o id
   }

    public function test_sales_are_created_correctly()
    {
        Event::fake();
        $admin = Users::factory(1)->create()->first();
        $this->actingAs($admin)->withSession(['user_id' => '1', 'role_id' => '1']);
        //metodo ja testado
        $request = Request::create('/sales', 'POST',$this->saleArray);
        $sale = new Sales();
        $response = $sale->create($request);
        $this->assertEquals(302, $response->getStatusCode());  // quando criado, ha o redirecionamento da venda

    }
    public function test_sales_are_edit_correctly()
    {
        Event::fake(); 
        $admin = Users::factory(1)->create()->first();
        $this->actingAs($admin)->withSession(['user_id' => '1', 'role_id' => '1']);

        $request = Request::create(route('sales.edit', ['sale'=>1]), 'PUT', $this->newSaleArray);
        
        $sale = new Sales();
        $saleId = json_decode($sale->get_sales_data(1))->id; // quero atualizar o primeiro elemento de vendas 
        $response = $sale->editSale($request, $saleId);
        $corretFormat = $sale->aplicacao_banco_de_dados_($this->newSaleArray['date']);
        $this->newSaleArray['date'] = $corretFormat;
        $this->assertDatabaseHas('client_products', $this->newSaleArray);
        $this->assertEquals(302, $response->getStatusCode());  
    }

    public function test_get_sales_betwen_dates_are_return_json_corretly(){
        Event::fake();
        $admin = Users::factory(1)->create()->first();
        $this->actingAs($admin)->withSession(['user_id' => '1', 'role_id' => '1']);

        $saleController = new Sales();
        $currentDateTime = new DateTime('now');
        $currentDate = $currentDateTime->format('Y-m-d');
        $response = $saleController->get_sales_betwen_dates('2016-01-01', $currentDate);

        $this->assertJson($response);
    }
    

}
