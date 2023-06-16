<x-app-layout>
    <x-slot name="header">
        <x-header-compact>
            <x-slot:content>
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon">
                            <i class="fad fa-industry-alt fa-lg"></i>
                        </div>
                        Empresa : {{$company->name}}
                    </h1>
                </div>

                <div class="col-12 col-xl-auto mb-3">
                    <button data-bs-toggle="modal" data-bs-target="#inviteModal"
                            class="btn btn-sm btn-light text-primary m-1">
                        <i class="fad fa-envelope-open fa-lg me-1"></i>
                       Enviar Convite
                    </button>
                </div>
            </x-slot:content>
        </x-header-compact>
    </x-slot>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <div class="row">
            {{$company}}
        </div>
    </div>

    <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Create Convite</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.reqInviteTo')}}" method="POST">
                    @csrf
                    <input type="hidden" name="company_id" value="{{$company->id}}">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role">Função</label>
                            <select class="form-select" name="role" id="role">
                                <option value="manager">Gerente</option>
                                <option value="user">Usuário</option>
                            </select>
                            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Fechar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
