<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Users;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

# php artisan test --filter=DashboardViewTest
class DashboardViewTest extends TestCase
{
    use RefreshDatabase;
    public function test_dashboard_view_product(){
        
        $admin = Users::factory()->create();
        $this->actingAs($admin)->withSession(['role_id'=>'1', 'user_id'=> '7']);

        $products = Product::factory(30)->create();
        $product = $products->first();

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertViewIs('dashboard');

        $this->assertIsObject($product);

    }



}
