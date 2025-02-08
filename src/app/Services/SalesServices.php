<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\SalesRepository;
use Illuminate\Http\Request;

class SalesServices
{
    private SalesRepository $salesRepository;
    private ProductRepository $productRepository;

    public function __construct(SalesRepository $salesRepository, ProductRepository $productRepository)
    {
        $this->salesRepository = $salesRepository;
        $this->productRepository = $productRepository;
    }

    public function createSalesService(Request $request): void
    {
        $this->salesRepository->createSaleRepository($request);
    }

    public function editSalesService(Request $request, int $id): void
    {
        $this->salesRepository->editSaleRepository($request, $id);
    }

    public function searchWithDateServices(Request $request): string
    {
        return $this->salesRepository->searchWithDateRepository($request);
    }

    public function getAllProducts(): string
    {
        return $this->productRepository->getAllProductsRepository();
    }

    public function getSaleServices(int $id): string
    {
        return $this->salesRepository->getSaleRepository($id);
    }

    public function getSalesByClientServices(Request $request, int $paginate = 15): string
    {
        $results =  ($this->salesRepository->getSalesByClientRepository($request, $paginate));
        $this->feedbackDbOperationsService(json_decode($results));
        return $results;
    }

    public function getClientNamesService(Request $request): string
    {
        return $this->salesRepository->getClientNamesRepository($request);
    }

    public function getSalesServices(int $paginate = 7): string
    {
        return $this->salesRepository->getSalesRepository($paginate);
    }

    public function lostCalculation(array $sales): string
    {
        $lost = 0;
        $totalSales = 0;
        foreach ($sales as $sale) {
            $priceOfSale = $sale->price_sales;
            if ($sale->status == "Devolvido" || $sale->status == "Cancelado") {
                $lost += $priceOfSale;
            } else if ($sale->status == "Aprovado") {
                $totalSales += $priceOfSale;
            }
        }
        $results = ["lost" => $lost, "totalSales" => $totalSales];
        $this->feedbackSalesServices($results);
        return json_encode($results);
    }

    public function messageToAdmin(array $balanceOfSales): array
    {
        if ($balanceOfSales['lost'] >= $balanceOfSales['totalSales'])
        {
            return ['type' => "messageAlert", 'feedback' => "As coisas não foram/estão indo bem nesse período :( Mas não desanime!"];
        } else
        {
            return ['type' => "message", 'feedback' => "O céu é o limite!"];
        }
    }

    public function feedbackSalesServices(array $feedback)
    {
        session()->forget('message');
        session()->forget('messageAlert');
        $feedback = $this->messageToAdmin($feedback);
        session()->flash(key: $feedback['type'], value: $feedback['feedback']);

    }
    public function feedbackDbOperationsService(array $results){
        if(empty($results)){
            $type = "messageAlert";
            $message = "Nenhum resultado encontrado!";
        }else{
            $type = "message";
            $message = "Resultados encontrados!";
        }
        session()->forget('message');
        session()->flash(key: $type, value: $message);
    }
}
