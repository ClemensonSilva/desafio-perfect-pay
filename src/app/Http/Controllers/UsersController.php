<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    private UserServices $userServices;
    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function index(){
        return view('registration_users');
    }
    public function indexLogin(){
            return view('login_users');
    }
    public function create(Request $request){
        $this->userServices->createServices($request);
        return redirect('/login')->with('message', "Usuário cadastrado com sucesso!"); // redireciona para pagina de login
    }
    public function login(Request $request){

        $response = json_decode($this->userServices->loginUserServices($request));
        switch ($response->code) {
            case 200:
                return redirect('/')->with(['message' => 'Seja bem vindo!', 'user'=> $response->user]);
                break;
            case 401:
                return redirect()->back()->with(["code"=> 401,'error'=> 'Senha incorreta.']); // retornar os dados do usuario logado
            break;
            case 404:
                return redirect('/login')->with(['code'=>404, 'error' =>'Usuario não encontrado. Por favor, peça para o admin cadastrá-lo.']);;
                break;
            default:
                return redirect('/login')->with(['code'=>404, 'erro' =>'Erro desconhecido.']);
        }

    }
    public function logOut(){
        Session::flush();
        return redirect('/login')->with('message', 'Usuario deslogado com sucesso!');
    }


}
