@extends('layout')

@section('content')
    <h1> Editar Produto</h1>
    @if (session()->has('message'))
    <div class="alert alert-success">
    {{session('message')}}
    </div>
@endif
@php
    
$product = json_decode($product);
@endphp
    <div class='card'>
        <div class='card-body'>
            <form action="/edit-product/{{$product->id}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nome do produto</label>
                    <input type="text" class="form-control " name="name" value="{{$product->name}}">
                </div>
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea type="text" rows='5' class="form-control" name="description"> {{$product->description}}</textarea>
                </div>
                <div class="form-group">
                    <label for="price">Preço</label>
                    <input type="text" class="form-control" name="price" placeholder="100,00 ou maior" value="{{$product->price}}">
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
@endsection
