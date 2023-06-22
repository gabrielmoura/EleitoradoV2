<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-industry-alt fa-lg"></i>
                        </div>
                        Empresas
                    </h1>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <form action="{{route('admin.company.store')}}" class="form" method="POST">
            @csrf
            <div class="row">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone')}}" required>
                </div>
                <div class="form-group">
                    <label for="doc_type">Tipo de documento</label>
                    <select name="doc_type" id="doc_type" class="form-control" value="{{old('doc_type')}}" required>
                        <option value="br_cnpj">CNPJ</option>
                        <option value="br_cpf">CPF</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="doc">Documento</label>
                    <input type="text" name="doc" id="doc" class="form-control" value="{{old('doc')}}" required>
                </div>
                <div class="form-group">
                    <x-media-library-attachment name="avatar" max-items="1" rules="mimes:png,jpg|max:1024" />
                </div>

            </div>
            <div class="row">
                <div class="col-md-2">
                    <button class="btn btn-primary " type="submit">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
