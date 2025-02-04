@extends('layout')
@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
            {{ session('user') }}

        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}

        </div>
    @endif
    @php
    # criar mais feedbacks para o usuario quanto a operacoes
        $products = json_decode($products);
        $sales = json_decode($sales);
        if(isset($balanceOfSales)){
            $balanceOfSales = json_decode($balanceOfSales);
        }


    @endphp
    <h1>Dashboard de vendas</h1>
    <div class='card mt-3'>
        <div class='card-body'>
            <h5 class="card-title mb-5">Tabela de vendas
                <a href='/sales' class='btn btn-secondary float-right btn-sm rounded-pill'><i class='fa fa-plus'></i> Nova
                    venda</a>
            </h5>
            <form action="/search" method="POST">
                @csrf
                <div class="form-row align-items-center">
                    <div class="col-sm-5 my-1">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Clientes</div>
                            </div>
                            <input type="text" class="form-control  " id="search" >
                        </div>
                    </div>

                </div>
                <div class="form-row align-items-center">
                    <div class="col-sm-5 my-1">
                        <select id="container" class="form-control" name="search">

                        </select>
                    </div>
                    <div class="col-sm-1 my-1">
                        <button type="submit" class="btn btn-primary" style='padding: 14.5px 16px;'>
                            <i class='fa fa-search'></i>
                        </button>
                    </div>
                </div>
            </form>

            <form action="/searchWithDate" method="POST">
                @csrf
                <div class="form-row align-items-center">
                    <div class="col-sm-5 my-1">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Data Inicial</div>
                            </div>
                            <input type="text" class="form-control single_date_picker" id="initialDate"
                                name="initialDate">
                        </div>
                    </div>
                    <div class="form-row align-items-center">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Data Final </div>
                            </div>
                            <input type="text" class="form-control single_date_picker" id="finalDate" name="finalDate">
                        </div>
                    </div>
                    <div class="col-sm-1 my-1">
                        <button type="submit" class="btn btn-primary" style='padding: 14.5px 16px;'>
                            <i class='fa fa-search'></i>
                        </button>
                    </div>
                </div>
            </form>
            @isset($balanceOfSales)
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
              google.charts.load('current', {'packages':['corechart']});
              google.charts.setOnLoadCallback(drawChart);
              var losts = parseFloat("<?php echo $balanceOfSales->losts; ?>");
              var gains = parseFloat("<?php echo $balanceOfSales->totalSales; ?>");
              function drawChart() {

                var data = google.visualization.arrayToDataTable([
                  ['Task', 'Hours per Day'],
                  ['Ganhos', gains],
                  ['Perdas', losts],
                ]);

                var options = {
                  title: 'Status das vendas'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
              }
            </script>
                <body>
                    <div id="piechart" style="width: 900px; height: 250px;"></div>
                </body>
            @endisset

            <table class='table'>
                <tr>
                    <th scope="col">
                        Produto
                    </th>
                    <th scope="col">
                        Data
                    </th>

                    <th scope="col">
                        Valor
                    </th>
                    <th scope="col">
                        Ações
                    </th>
                </tr>

                @forelse ($sales as $sale)
                <tr>
                    <td>
                        {{ $sale->products_name }}
                    </td>
                    <td>
                        {{ banco_de_dados_aplicacao($sale->date) }}
                    </td>
                    <td>
                        R${{ $sale->price_sales }},00
                    </td>
                    <td>
                        <a href='/edit-sale/{{ $sale->id }}' class='btn btn-primary'>Editar</a>
                    </td>
                </tr>
                @empty
                <td>
                    Nenhuma venda encontrada
                </td>
                @endforelse
            </table>
        </div>
    </div>
    <div class='card mt-3'>
        <div class='card-body'>
            <h5 class="card-title mb-5">Resultado de vendas</h5>
            <table class='table'>
                <tr>
                    <th scope="col">
                        Status
                    </th>
                    <th scope="col">
                        Quantidade
                    </th>
                    <th scope="col">
                        Preço com desconto
                    </th>
                </tr>
                @foreach ($sales as $sale)
                    <tr>
                        <th scope="col">
                            {{ $sale->status }}
                        </th>
                        <th scope="col">
                            {{ $sale->quantity }}
                        </th>
                        <th scope="col">
                            R$ {{ $sale->products_price - $sale->discount }}
                        </th>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class='card mt-3'>
        <div class='card-body'>
            <h5 class="card-title mb-5">Produtos
                <a href='/products' class='btn btn-secondary float-right btn-sm rounded-pill'><i class='fa fa-plus'></i>
                    Novo produto</a>
            </h5>
            <table class='table'>
                <tr>
                    <th scope="col">
                        Nome
                    </th>
                    <th scope="col">
                        Valor
                    </th>
                    @if (Session::get('role_id') === 1)
                        <th scope="col">
                            Ações
                        </th>
                        <th scope="col">

                        </th>
                    @endif
                </tr>

                @foreach ($products as $product)
                    <tr>
                        <td>
                            {{ $product->name }}
                        </td>
                        <td>
                            R$ {{ $product->price }}
                        </td>
                        @if (Session::get('role_id') === 1)
                            <td>
                                <a href='/edit-product/{{ $product->id }}' class='btn btn-primary'>Editar</a>
                            </td>
                            <td>
                                <form action="/edit-product/{{ $product->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class='btn btn-danger'>Excluir</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </table>
            <form action="/deslogar" method="GET">
                @csrf
                <button type="submit" class='btn btn-danger'>Deslogar</button>
            </form>
        </div>
    </div>
@endsection
<html>
<script src="https://code.jquery.com/jquery-3.7.1.slim.js"
    integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>

<script>
    function searchClient(search) {
        return $.ajax({
            type: "GET",
            url: "/search/client",
            data: {
                'search': search
            },
            dataType: "json",
        });
    }
// CRIAR PAGINACAO DE RESULTADOS
    function createParagrapDinamically(result) {
        var i = 0;
        result.forEach(client => {
            i++;
            var client = result[i - 1]['cpf'];
            const newParag = $('<option>', {
                id: 'result' + i,
                text: result[i - 1]['name'],
                style: 'margin: 10px'
            });
            $("#container").append(newParag);
            $(document).on('click', '#result1', function () {
                var client = ('#result'+i).val();
                $("#search").val(client);
            });
        });
    }
    $("#container").on('change', function () {
        var selectedValue = $(this).val();
        var selectedText = $(this).find('option:selected').text();
        $("#search").val(selectedText)
    })
    $(document).ready(function() {
        $("#search").on('keydown', function() {
            $("#result").html($(this).val());
            var search = $(this).val();
            if (search != '') {
                var container = $("#container");
                container.empty();
                searchClient(search).then((result) => {
                    createParagrapDinamically(result);
                }).catch((err) => {

                });
            }
        })

    })
</script>

</html>
