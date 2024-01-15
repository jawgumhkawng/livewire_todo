<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public $perPage = 5;
    public function render()
    {
        return view(
            'livewire.user-list',
            [
                'users' => User::latest()->paginate($this->perPage),
            ]
        );
    }
}