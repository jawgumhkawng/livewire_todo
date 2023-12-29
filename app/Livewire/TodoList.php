<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    #[Rule('required|min:3|max:20')]
    public $name;

    public $search;
    public function create()
    {
        $validated = $this->validateOnly('name');

        Todo::create($validated);

        $this->reset('name');

        session()->flash('success', 'Created!');
    }
    public function render()
    {
        return view(
            'livewire.todo-list',
            [
                'todos' => Todo::latest()->paginate(4),
            ]
        );
    }
}
