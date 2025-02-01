@extends('layout')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1>Adicionar / Editar Venda</h1>
    @if (session('errors'))
        <div class="alert alert-danger">
            {{ session('errors') }}
        </div>
    @endif
    @php
        $clients = json_decode($clients);
        $products = json_decode($products);
    @endphp
    <div class='card'>
        <div class='card-body'>
            <button type="button" class="btn btn-secondary float-right btn-sm rounded-pill" data-toggle="modal"
                data-target="#exampleModalCenter">
                Novos clientes <i class='fa fa-plus'></i>
            </button>

            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Cadastrando novos clientes</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="/register" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nome do cliente</label>
                                    <input type="text" class="form-control " name="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="cpf">CPF</label>
                                    <input type="text" class="form-control" name="cpf" placeholder="99999999999">
                                </div>
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                                <br>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <form action="/sales" method="POST">
                @csrf
                <h5 class='mt-5'>Informações da venda</h5>
                <div class="form-group">
                    <label for="product">Cliente</label>
                    <select name="client_id" class="form-control">
                        @foreach ($clients as $client)
                            <option client_id value = "{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="product">Produto</label>
                    <select id="product" name="product_id" class="form-control">
                        @foreach ($products as $product)
                            <option value = "{{ $product->id }}"> {{ $product->name }} - por apenas R$
                                {{ $product->price }},00</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Data</label>
                    <input type="text" class="form-control single_date_picker" id="date" name="date">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantidade</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" placeholder="1 a 10">
                </div>
                <div class="form-group">
                    <label for="discount">Desconto</label>
                    <input type="text" class="form-control" id="discount" name="discount" placeholder="100,00 ou menor">
                </div>
                <div>
                    <input type="hidden" name="salesPerson" value={{ Session::get('user_id') }}>
                </div>
                @php
                    $status = ['Aprovado', 'Cancelado', 'Devolvido'];
                @endphp
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" class="form-control" name="status">
                        <option selected>Escolha...</option>
                        @foreach ($status as $status)
                            <option>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
@endsection
