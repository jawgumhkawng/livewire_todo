<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    //search
    #[Url()]
    public $search = '';

    //sort
    #[Url()]
    public $perPage = 5;

    #[Url()]
    public $sortBy = 'created_at';

    #[Url()]
    public $sortDir = 'DESC';
    //is_admin
    #[Url()]
    public $admin = '';

    public function delete(User $user)
    {
        $user->delete();
    }

    public function setSortName($sortByName)
    {
        if ($this->sortBy === $sortByName) {
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : 'ASC';
            return;
        }
        $this->sortBy = $sortByName;
    }
    public function render()
    {
        return view(
            'livewire.user-list',
            [
                'users' => User::search($this->search)
                    ->when($this->admin !== '', function ($query) {
                        $query->where('is_admin', $this->admin);
                    })
                    ->orderBy($this->sortBy, $this->sortDir)
                    ->paginate($this->perPage),
            ]
        );
    }
}
