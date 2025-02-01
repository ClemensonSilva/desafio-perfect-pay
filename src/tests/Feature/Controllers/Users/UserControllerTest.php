<?php

namespace Tests\Feature;

use App\Http\Controllers\UsersController;
use App\Models\Users;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Testing\Fakes\EventFake;

# php artisan test --filter=UserCreated
class UserCreated extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    public function test_user_are_created_correctly()
    {
        Event::fake();

        $request = Request::create('/registerUser','POST', [
            'role_id' => '1',
            'name' => 'Dorivalson Duarte',
            'email' => 'DorivalsonDuarte@gmail.com',
            'password' => crypted('salmao')
        ] );

        $controller = new UsersController;

        $response = $controller->create($request);
        $this->assertEquals(302, $response->getStatusCode());


        $this->assertDatabaseHas('users', [ 'role_id' => '1',
        'name' => 'Dorivalson Duarte',
        'email' => 'DorivalsonDuarte@gmail.com',
    ]);     
        $this->assertEquals(true, verifyPassword('salmao',crypted('salmao')));
    }

    /* 
    public function test_user_are_updated_correctly()
    {
        Event::Fake();
        $user = Users::create([
            'role_id' => '1',
            'name' => 'Dorivalson Duarte',
            'email' => 'DuarteDorivalson@gmail.com',
            'password' => crypted('atum')
        ]);
        $request = Request::create('/registerUser','POST', [
            'role_id' => '1',
            'name' => 'Dorivalson Duarte',
            'email' => 'DorivalsonDuarte@gmail.com',
            'password' => crypted('salmao')
            ] );
            
            $user = new UsersController();
            
            
            criar route     
            $this->assertDatabaseHas('users', ['role_id' => $userUpdateData['role_id'], 'name' => $userUpdateData['name'],
            'email'=> $userUpdateData['email'], 'password' =>$userUpdateData['password']]);
            
            $this->assertEquals(true, verifyPassword('atum', $user->password));
        }
        */
        
        public function test_user_are_logged_correctly()
        { 
        Event::fake();
        $request = Request::create('/registerUser','POST', 
        ['role_id' => '1',
        'name' => 'Dorivalson Duarte',
        'email' => 'DorivalsonDuarte@gmail.com',
        'password' => crypted('salmao')
        ] );
        

        
        $user = new UsersController();
        $response = $user->login($request);
        
        $this->assertEquals(302, $response->getStatusCode());
        
    }  

    public function test_user_are_logged_wrongly_password()
    { 
        
        $response = $this->from('login')->post('loginUsers', [
        'role_id' => '1',
        'name' => 'Dorivalson Duarte',
        'email' => 'DorivalsonDuarte@gmail.com',
        'password' => crypted('atum')
        ]);
        $response->assertRedirect('/login');        
    }

    public function test_user_are_logged_wrongly_email()
    { 
        
        $response = $this->from('login')->post('loginUsers', [
        'role_id' => '1',
        'name' => 'Dorivalson Duarte',
        'email' => 'DuarteDorivalson@gmail.com',
        'password' => crypted('salmao')
        ]);
        $response->assertRedirect('/login');        
    }
   
}
