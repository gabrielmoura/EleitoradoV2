<?php

namespace App\Http\Livewire\Person;

use App\Models\Person;
use App\Service\Trait\Table\WithReordering;
use App\Service\Trait\Table\WithSearch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    use WithReordering;
    use WithSearch;

    public $perPage = 25;

    public $selectedItems = [];

    //    protected $rules = [
    //        'name' => ['required', 'string', 'min:3', 'max:255'],
    //        'description' => ['nullable', 'string', 'min:3', 'max:255'],
    //    ];

    protected $listeners = ['refresh' => '$refresh'];

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.person.index', [
            'people' => Person::search($this->search)
                ->orderBy($this->defaultReorderColumn, $this->defaultReorderASC ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }

    public function setSelect($id): void
    {
        $this->selectedItems[] = $id;
    }

    public function exportSelected($to): void
    {
        $this->emit('exportSelected', $to, $this->selectedItems);
    }

    public function delete($id): void
    {
        $this->authorize('delete_person');
        Person::find($id)->delete();
        flash()->addSuccess('Pessoa deletada com sucesso.');
        $this->emit('refresh');
    }
}
