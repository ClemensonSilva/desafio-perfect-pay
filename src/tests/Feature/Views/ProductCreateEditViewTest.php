<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Models\Users;
use App\Models\Roles;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

# php artisan test --filter=ProductViewTest
class ProductViewTest extends TestCase
{
    
    use RefreshDatabase;
 

    // teste para ver se os produtos estao sendo enviados para a view dashboard
    public function test_dashboard_are_showed_only_for_usersLogged_corretly(){

        $user = Users::factory()->create();

        $this->actingAs($user)->withSession(['role_id'=>'1', 'user_id'=> '7']);

        $response = $this->get('/');

        $response->assertStatus(200);   
    }
    public function test_dashboard_are_not_showed_for_usersNotLogged_corretly(){

        $response = $this->get('/');

        $response->assertStatus(302);   
    }
    public function test_edit_products_are_showed_only_for_admins_corretly(){

        $admin = Users::factory()->create();
        $this->actingAs($admin)->withSession(['role_id'=>'1', 'user_id'=> '7']);
        $product = Product::factory(1)->create()->first();
     
        $response = $this->get(route('product.show',['product'=>$product->id]));
        $response->assertStatus(200);

    }    public function test_edit_products_are_not_showed_for_not_admins_corretly(){

        $admin = Users::factory()->create();
        $this->actingAs($admin)->withSession(['role_id'=>'2', 'user_id'=> '7']);
        $product = Product::factory(1)->create()->first();
     
        $response = $this->get(route('product.show',['product'=>$product->id]));
        $response->assertStatus(302);

    }
    public function test_crud_products_are_showed_only_for_admins_corretly(){

        $admin = Users::factory()->create();
        $this->actingAs($admin)->withSession([ 'role_id'=>'1', 'user_id'=> '7']);
        $product = Product::factory(1)->create()->first();
     
        $response = $this->get(route('product.create'));
        $response->assertStatus(200);

    }
    public function test_crud_products_are_not_showed_for_not_admins_corretly(){

        $admin = Users::factory()->create();
        $this->actingAs($admin)->withSession([ 'role_id'=>'2', 'user_id'=> '7']);
        $product = Product::factory(1)->create()->first();
     
        $response = $this->get(route('product.create'));
        $response->assertStatus(302);

    }



    // teste para
    // teste para
    // teste para
    // teste para



}
