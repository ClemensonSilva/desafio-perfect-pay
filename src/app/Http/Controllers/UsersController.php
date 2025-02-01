<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{

    public function index(){
        return view('registration_users');
    }
    public function indexLogin(){
            return view('login_users');
    }
    public function login(Request $request){
       
        $input = $request->validate([
            'email'=> 'required|unique:client',
            'password'=> 'required|min:8',
        ]);

        $user = Users::where('email', $input['email'])->first();   
        if($user){
            if(verifyPassword($input['password'], $user->password)){
                Session::put('name', $user->name);
                Session::put('user_id', $user->id);
                Session::put('role_id', $user->role_id);
                return redirect('/')->with(['message' => 'Seja bem vindo!', 'user'=> $user->name]);
            }
            else{
                return redirect()->back()->with(['error'=> 'Senha incorreta.']); // retornar os dados do usuario logado
            }
        }else {
            return redirect('/login')->with(['error' =>'Usuario não encontrado. Por favor, peça para o admin cadastrá-lo.']);;
        }
    }
    public function logOut(){
        Session::flush();
        return redirect('/login')->with('message', 'Usuario deslogado com sucesso!');
    }
    public function create(Request $request){
        $inputForm = $request->validate([
            'role_id' => 'required',
            'name'=> 'required',
            'email'=> 'required|unique:users|email',
            'password'=> 'required|min:8',
        ]);

        $inputForm['name'] = strip_tags($inputForm['name'] );
        $inputForm['email'] = strip_tags($inputForm['email'] );
        $inputForm['role_id'] = strip_tags($inputForm['role_id'] );
        $inputForm['password'] = strip_tags($inputForm['password'] );
        $inputForm['password'] = crypted($inputForm['password']);

        Users::create($inputForm);

        return redirect('/login')->with('message', "Usuário cadastrado com sucesso!"); // redireciona para pagina de login

    }

    public function edit(Users $users, Request $request){
        // implementa bloqueio para que apenas admin possam editar login de usuarios
        $input = $request->validate(
          [ 
           'role_id' => 'required',
            'name'=> 'required',
            'email'=> 'required|unique:client',
            'password'=> 'required|min:8',
          ]
       );
       // fazer strip_tags no request do form de update tambem

       $users['role_id'] = $input['role_id']; 
       $users['name'] = $input['name'];
       $users['email'] = $input['email'];
       $users['password'] = $input['password'];

       $users->update($input);

       return redirect('/sales');

    }
}
