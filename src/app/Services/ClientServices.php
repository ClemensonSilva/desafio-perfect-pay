<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;

class ClientServices
{
    public static function CreateClient($request)
    {
        ClientRepository::createClient($request);
        Cache::forget('clients');

    }
    public static function getClients(){
        return ClientRepository::getClients();
    }
    public static function searchClient($clientName){
        return ClientRepository::searchClient($clientName);
    }
}
