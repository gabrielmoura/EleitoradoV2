<?php

namespace App\Http\Livewire;

use App\Models\Person;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\RateLimiter;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class PersonTable extends DataTableComponent
{
    public int $perPage = 25;

    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];

    protected $model = Person::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function builder(): Builder
    {

        return Person::query()
            ->with(['address', 'groups'])
            ->select();
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable(),
            Column::make('Nome', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),
            Column::make('Celular', 'cellphone')
                ->sortable()
                ->searchable(),
            Column::make('Cpf', 'cpf')
                ->sortable(),
            Column::make('Rg', 'rg')
                ->sortable(),
            Column::make('Endereço', 'address.street')->label(fn ($row) => $row->addresses->street ?? null),
            ButtonGroupColumn::make('Actions')->attributes(function ($row) {
                return [
                    'class' => 'space-x-2',
                ];
            })->buttons([
                LinkColumn::make('View') // make() has no effect in this case but needs to be set anyway
                    ->title(fn ($row) => 'Ver ')
                    ->location(fn ($row) => route('dash.person.show', $row->pid))
                    ->attributes(function ($row) {
                        return [
                            'class' => 'badge bg-primary',
                        ];
                    }),
                LinkColumn::make('Edit')
                    ->title(fn ($row) => 'Editar')
                    ->location(fn ($row) => route('dash.person.edit', $row->pid))
                    ->attributes(function ($row) {
                        return [
                            'target' => '_blank',
                            'class' => 'badge bg-primary',
                        ];
                    }),
            ]),
            //            Column::make('Remoção', 'pid')
            //                ->label(
            //                    fn ($row) => /** @lang text */ '<form action='.route('dash.person.destroy', ['voter' => $row->pid])." method='POST'>
            //                            <input type='hidden' name='_method' value='DELETE'>
            //                            <input type='hidden' name='_token' value=".csrf_token().">
            //                            <button type='submit'>Remover</button>
            //                        </form>"
            //                )
            //                ->html()
            //                ->hideIf(! \Auth::user()->hasRole('manager')),
        ];
    }

    public function exportSelected()
    {
        $users = $this->getSelected();

        $executed = RateLimiter::attempt(
            'export:voters',
            $perMinute = 5,
            function () use ($users) {
                return Excel::download(new VotersExport($users), 'voters.xlsx');
            }
        );
        if (! $executed) {
            flash()->addError('Too many messages sent!', 'Error');
        }
        $this->clearSelected();

        return $executed;
    }
}
