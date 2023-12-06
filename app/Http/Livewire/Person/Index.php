<?php

namespace App\Http\Livewire\Person;

use App\Models\Person;
use App\Service\Trait\Table\WithFilter;
use App\Service\Trait\Table\WithReordering;
use App\Service\Trait\Table\WithSearch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use AuthorizesRequests;
    use WithFilter;
    use WithPagination;
    use WithReordering;
    use WithSearch;

    public $perPage = 25;

    public $selectedItems = [];

    protected $listeners = ['refresh' => '$refresh'];

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.person.index', [
            'people' => Person::with('address')
                ->whereLike([
                    'name',
                    'email',
                    'cpf',
                    'rg',
                    'cellphone',
                    'telephone',
                    'address.street',
                    'address.number',
                    'address.district',
                    'address.city',
                    'address.state',
                    'address.zipcode',
                ], $this->search)
                ->whenLike($this->filter['district'] ?? null, 'address.district')
                ->whenLike($this->filter['city'] ?? null, 'address.city')
                ->whenLike($this->filter['cpf'] ?? null, 'cpf')
                ->whenLike($this->filter['rg'] ?? null, 'rg')
                ->whenLike($this->filter['cellphone'] ?? null, 'cellphone')
                ->whenLike($this->filter['telephone'] ?? null, 'telephone')
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
