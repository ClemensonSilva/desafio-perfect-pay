<?php

namespace App\Http\Controllers;

use App\Services\ClientServices;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private ClientServices $clientServices;
    public function __construct(ClientServices $clientServices)
    {
        $this->clientServices = $clientServices;
    }
    public function create(Request $request){
        $this->clientServices->createClient($request);
        return redirect('/sales');
    }
    public function getClients(){
      return  $this->clientServices->getClients();
    }
    public function searchClient($clientName){
     return  $this->clientServices->searchClient($clientName);
    }
}
