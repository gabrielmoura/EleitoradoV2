<x-app-layout>

    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Funções') }}
        </h2>
    </x-slot>


    <!-- Modal -->
    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
        <div class="modal-dialog" role="document">

            <form method="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="roleModalLabel">{{__('view.role')}}</h4>
                </div>
                <div class="modal-body">
                    <!-- name Form Input -->
                    <div class="form-group @if ($errors->has('name')) has-error @endif">

                        <label for="name">Name</label>
                        <input type="text" class="form-control" placeholder="Role Name" id="name" name="name" />
                        @if ($errors->has('name'))
                            <p class="help-block">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Close')}}</button>

                    <!-- Submit Form Button -->
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <h3>{{__('view.roles')}}</h3>
        </div>
        <div class="col-md-7 page-action text-right">
            @can('add_roles')
                <a href="#" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#roleModal"> <i
                        class="glyphicon glyphicon-plus"></i> New</a>
            @endcan
        </div>
    </div>


    @forelse ($roles as $role)
        <form action="{{route('admin.role.update',  $role->id)}}" class="m-b">
            @method('PUT')
            @if($role->name === 'admin')
                @include('admin.role.permission', [
                              'title' => $role->name .' Permissions',
                              'options' => ['disabled'] ])
            @else
                @include('admin.role.permission', [
                              'title' => $role->name .' Permissions',
                              'model' => $role ])
                @role('admin')
                <button type="submit" class="btn btn-primary">Salvar</button>
                @endrole
            @endif
        </form>

    @empty
        <p>No Roles defined, please run <code>php artisan db:seed</code> to seed some dummy data.</p>
    @endforelse
</x-app-layout>
