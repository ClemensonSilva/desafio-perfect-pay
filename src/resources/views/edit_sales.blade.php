@extends('layout')

@section('content')
    <h1>Adicionar / Editar carro</h1>

    @php
            $sale = json_decode($sale);
            $products = json_decode($products);

    @endphp
    <div class='card'>
        <div class='card-body'>
            <form action="/edit-sale/{{$sale->id}}" method="POST">
                @csrf
                @method('PUT')
                <h5 class='mt-5'>Informações da venda </h5>
                <div class="form-group">
                    <label for="product">Produto</label>
                    <select id="product" name="product_id"  class="form-control">
                        <option selected value = "{{$sale->product_id}}">{{$sale->products_name}}</option>
                        @foreach ($products as $product)
                        <option value = "{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <input type="hidden" class="form-control"  id="client_id" value="{{$sale->client_id}}" name="client_id">
                </div>
                <div class="form-group">
                    <label for="date">Data</label>
                    <input type="text" class="form-control single_date_picker"  id="date" value="{{banco_de_dados_aplicacao($sale->date)}}" name="date">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantidade</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" value="{{$sale->quantity}}">
                </div>
                <div class="form-group">
                    <label for="discount">Desconto</label>
                    <input type="text" class="form-control" id="discount" name="discount" value="{{$sale->discount}}">
                </div>
                @php
                    $status = [ 'Cancelado', 'Devolvido'];
                @endphp
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" class="form-control" name="status" >
                        <option selected >{{$sale->status}}</option>
                        @foreach ($status as $status)
                            <option >{{$status}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>

    </div>
@endsection
