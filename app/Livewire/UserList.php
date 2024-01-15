<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    //search
    public $search = '';

    //sort
    public $perPage = 5;

    //is_admin
    public $admin = '';

    public function delete(User $user)
    {
        $user->delete();
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
                    ->latest()->paginate($this->perPage),
            ]
        );
    }
}
