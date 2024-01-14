<?php

namespace App\Livewire;

use App\Models\Todo;
use Exception;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    #[Rule('required|min:3|max:20')]
    public $name;

    public $search;
    public $editTodoId;

    #[Rule('required|min:3|max:20')]
    public $editTodoName;
    public function create()
    {
        $validated = $this->validateOnly('name');

        Todo::create($validated);

        $this->reset('name');

        session()->flash('success', 'Created!');

        $this->resetPage();
    }

    public function toggle($todoId)
    {
        $todo = Todo::find($todoId);
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function edit($todoId)
    {
        $this->editTodoId = $todoId;
        $this->editTodoName = Todo::find($todoId)->name;
    }

    public function cancelEdit()
    {
        $this->reset('editTodoId', 'editTodoName');
    }

    public function update()
    {
        $this->validateOnly('editTodoName');
        Todo::find($this->editTodoId)->update([
            'name' => $this->editTodoName
        ]);

        $this->cancelEdit();

        session()->flash('update', 'Updated!');
    }
    public function delete($todoId)
    {
        try {
            Todo::findOrFail($todoId)->delete();
        } catch (Exception $e) {
            session()->flash('error', 'Failed To Delete This ToDo!');
            return;
        }
    }

    public function mount($search)
    {
        $this->search = $search;
    }

    #[Computed()]
    public function todos()
    {
        return Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(4);
    }

    public function render()
    {
        return view(
            'livewire.todo-list',
            []
        );
    }
}
