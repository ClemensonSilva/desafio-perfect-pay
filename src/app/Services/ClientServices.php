<?php

namespace App\Services;

use App\Repositories\ClientRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ClientServices
{
    private  ClientRepository $clientRepository; // criando atributo cujo tipo é a classe ClientRepository
    public function __construct(ClientRepository $clientRepository){
        $this->clientRepository =  $clientRepository; // instanciando a classe
    }
    public  function createClient(Request $request)
    {
        Cache::forget('clients');
        $this->clientRepository->createClient($request);
    }
    public  function getClients(){
        return $this->clientRepository->getClients();
    }
    public  function searchClient(string $clientName){
        return $this->clientRepository->searchClient($clientName);
    }
}
