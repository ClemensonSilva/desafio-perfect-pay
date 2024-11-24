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
    @endphp
    <h1>Desempenho</h1>
    <div class='card mt-3'>
        <div class='card-body'>
            <h6>Período de avaliação</h6>
            <form action="/searchWithDate" method="POST">
                @csrf
                <div class="form-row align-items-center">
                    <div class="col-sm-5 my-1 mr-3">
                        <div class="input-group ">
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
            <h6 class="card-title mt-5">Nome do vendedor</h6>
            <table class='table'>
                <tr>
                    <th scope="col">
                        Proximidade da meta de vendas
                    </th>
                    <th scope="col">
                        Taxa de vendas bem sucedidas
                    </th>
                  
                    <th scope="col">
                        Comparacao com o mês anterior
                    </th>
                    
                </tr>

                <tr>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
              
            </table>
            <div>
                <p>  *Proximidade da meta de vendas: mede o quão proximo o vendedor esta de sua meta no período
                </p>
                <p>*Taxa de vendas bem sucedidas: Calcula a porcentagem de vendas com status 'Sucesso' 
                    frente ao total de vendas que poderiam, dentro do prazo, serem canceladas;</p>
            </div>

        </div>
    </div>
  
  
@endsection


