<?php

namespace App\Http\Livewire\Person;

use App\Models\Person;
use App\Service\Trait\Table\WithReordering;
use App\Service\Trait\Table\WithSearch;
use Illuminate\Database\Eloquent\Builder;
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
            'people' => Person::with('address')
                ->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%')
                ->orWhere('cpf', 'like', '%'.$this->search.'%')
                ->orWhere('rg', 'like', '%'.$this->search.'%')
                ->orWhere('dateOfBirth', 'like', '%'.$this->search.'%')
                ->orwhere('cellphone', 'like', '%'.$this->search.'%')
                ->orwhere('telephone', 'like', '%'.$this->search.'%')
                ->orwhere('voter_registration', 'like', '%'.$this->search.'%')
                ->orWhereHas('address', function (Builder $query) {
                    $query->where('street', 'like', '%'.$this->search.'%')
                        ->orWhere('number', 'like', '%'.$this->search.'%')
                        ->orWhere('complement', 'like', '%'.$this->search.'%')
                        ->orWhere('city', 'like', '%'.$this->search.'%')
                        ->orWhere('state', 'like', '%'.$this->search.'%')
                        ->orWhere('country', 'like', '%'.$this->search.'%')
                        ->orWhere('zipcode', 'like', '%'.$this->search.'%');
                })
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
