<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function create(Request $request){
        $inputForm = $request->validate([
            'name'=> 'required',
            'email'=> 'required|unique:client',
            'cpf'=> 'required|unique:client|max:15',
        ]);

        $inputForm['name'] = strip_tags($inputForm['name'] );
        $inputForm['email'] = strip_tags($inputForm['email'] );
        $inputForm['cpf'] = strip_tags($inputForm['cpf'] );

        Client::create($inputForm);
        Cache::forget('clients');
        return redirect('/sales');
    }

    public function getClients(){
        $clients = Cache::remember('clients', 60*30, function(){
            return DB::select('select * FROM client ORDER BY name');
        });
        return $clients;
    }
    public function searchClient($clientName){
        $client = DB::select("SELECT * FROM client WHERE name LIKE CONCAT ('%', :name, '%')", ['name'=>$clientName]);
        return json_encode($client);
    }
}
