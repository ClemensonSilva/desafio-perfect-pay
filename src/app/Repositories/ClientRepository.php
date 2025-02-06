<?php

namespace App\Repositories;

use App\Models\Client;
use App\Validation\ClientValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ClientRepository
{
    public static function  createClient(Request $request): void
    {
        $userData = ClientValidation::validateClient($request);
        Client::create($userData);
    }
    public static function getClients():array {
        $clients = Cache::remember('clients', 60*30, function(){
            return DB::select('select * FROM client ORDER BY name');
        });
        return $clients;
    }
    public static function searchClient(string $clientName):string {
        $client = DB::select("SELECT * FROM client WHERE name LIKE CONCAT ('%', :name, '%')", ['name'=>$clientName]);
        return json_encode($client);
    }
}
