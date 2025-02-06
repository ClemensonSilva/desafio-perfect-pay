<?php

namespace App\Repositories;

use App\Models\Client;
use App\Validation\ClientValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ClientRepository
{
    private ClientValidation $clientValidation;
    public function __construct(ClientValidation $validation)
    {
        $this->clientValidation = $validation;
    }
    public  function  createClient(Request $request): void
    {
        $userData = $this->clientValidation->validateClient($request);
        Client::create($userData);
    }
    public  function getClients():array {
        $clients = Cache::remember('clients', 60*30, function(){
            return DB::select('select * FROM client ORDER BY name');
        });
        return $clients;
    }
    public  function searchClient(string $clientName):string {
        $client = DB::select("SELECT * FROM client WHERE name LIKE CONCAT ('%', :name, '%')", ['name'=>$clientName]);
        return json_encode($client);
    }
}
