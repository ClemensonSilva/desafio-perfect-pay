<?php

    namespace App\Http\Controllers;

    use App\Services\SalesServices;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Redirector;
    use Illuminate\View\View;

    class Sales extends Controller
    {
        private SalesServices $salesServices;


        public function __construct(SalesServices $salesServices)
        {
            $this->salesServices = $salesServices;
        }

        public function dataToEditSales(int $id):View
        {
            $products = $this->salesServices->getAllProducts();
            $sale = $this->salesServices->getSaleServices($id);
            return view("edit_sales", compact("sale", "products")); // parei aqui
        }

        public function search(Request $request):View
        {
            $products = $this->salesServices->getAllProducts();
            $sales = $this->salesServices->getSalesByClientServices($request);
            return view("dashboard")
                ->with(compact("products", "sales"))
                ->with("message", "Resultados encontrados");
        }

        function getClientNames(Request $request):string
        {
            return $this->salesServices->getClientNamesService($request);
        }

        public function create(Request $request):Redirector|RedirectResponse
        {
            $this->salesServices->createSalesService($request);
            return redirect("/sales")->with("sucess", "Venda feita com sucesso!");
        }

        public function editSale(Request $request, $id):Redirector|RedirectResponse
        {
            $this->salesServices->editSalesService($request, $id);
            return redirect("/")->with(["message" => "Edicao feita com sucesso!"]);
        }

        public function searchWithDate(Request $request):View|string
        {
            try {
                $products = $this->salesServices->getAllProducts();
                $sales = $this->salesServices->searchWithDateServices($request);
                $balanceOfSales = $this->salesServices->lostCalculation(\json_decode($sales));
                return view("dashboard", compact("products", "sales", "balanceOfSales"))->with([
                    "message" => "Resultados encontrados",
                ]);
            } catch (\Throwable $th) {
                return redirect("dashboard")->with([
                    "message" => "Resultados não encontrados",
                ]);
            }
        }


    }
