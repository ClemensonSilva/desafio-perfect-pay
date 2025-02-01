<?php

namespace Tests\Feature;

use App\Http\Controllers\ClientController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;


# php artisan test --filter=ClientRegistration
class ClientRegistration extends TestCase
{   
    use RefreshDatabase;
    use WithoutMiddleware;
    public function test_client_are_set_correctly(){
        Event::fake();

        $request = Request::create('/products', 'POST',[ 
            'name'=>'Jhonny Dogs',
            'email'=>'jhonyDogs@gmail.com',
            'cpf'=>'000000000-00'
        ]);
        
        $controller = new ClientController;
        $response = $controller->create($request);

        $this->assertEquals(302, $response->getStatusCode());

        $this->assertDatabaseHas('client', ['email'=>'jhonyDogs@gmail.com']);
        $this->assertDatabaseHas('client',['name'=>'Jhonny Dogs']);
        $this->assertDatabaseHas('client', ['cpf'=>'000000000-00']);



    }




}
