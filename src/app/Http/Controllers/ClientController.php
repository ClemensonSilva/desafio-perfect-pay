<?php

namespace App\Http\Controllers;

use App\Services\ClientServices;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function create(Request $request){
        ClientServices::CreateClient($request);
        return redirect('/sales');
    }
    public function getClients(){
      return  ClientServices::getClients();
    }
    public function searchClient($clientName){
     return  ClientServices::searchClient($clientName);
    }
}
