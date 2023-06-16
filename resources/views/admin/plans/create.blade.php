<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-money-check-edit fa-lg"></i>
                        </div>
                        Planos -> Criar Plano
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="container">

        <form action="{{route('admin.plan.store')}}" method="post">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nome do plano">
                </div>
                <div class="col-md-6">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug do plano">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="description" class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="description" name="description"
                           placeholder="Descrição do plano">
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Preço em centavos</label>
                            <input type="text" class="form-control" id="price" name="price"
                                   placeholder="Preço do plano">
                        </div>
                        <div class="col-md-6">
                            <label for="price_decimal" class="form-label">Preço em decimal</label>
                            <input type="text" class="form-control money" id="price_decimal" name="price_decimal"
                                   placeholder="Preço do plano">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="interval_count" class="form-label">Repetição</label>
                    <input type="number" class="form-control" id="interval_count" name="interval_count" value="1"
                           placeholder="Duração do plano">
                </div>
                <div class="col-md-6">
                    <label for="billing_period" class="form-label">Tipo de Repetição</label>
                    <select class="form-select" aria-label="Default select example" name="billing_period"
                            id="billing_period">
                        <option value="month">Mês</option>
                        {{--                        <option value="year">Ano</option>--}}
                        <option value="week">Semana</option>
                        <option value="day">Dia</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="features" class="form-label">Funcionalidades</label>
                    <input class="form-control tselect-multi-create" name="features" id="features">
                </div>

                <div class="col-md-6">
                    <label for="currency" class="form-label">Tipo de Moeda</label>
                    <select class="form-select" aria-label="Default select example" name="currency"
                            id="currency">
                        <option value="BRL">Real</option>
                        <option value="USD">Dólar</option>
                        <option value="EUR">Euro</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</x-app-layout>
