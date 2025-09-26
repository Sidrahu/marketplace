<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UsersIndex extends Component
{
    use WithPagination;

    public $name, $email, $password, $user_id, $role;
    public $isOpen = false;

    protected $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'nullable|min:6',
        'role' => 'required|string'
    ];

    public function render()
    {
        return view('livewire.admin.users.users-index', [
            'users' => User::with('roles')->paginate(10),
            'roles' => Role::all()
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetFields();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate();

        $user = User::updateOrCreate(
            ['id' => $this->user_id],
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password 
                    ? bcrypt($this->password) 
                    : User::find($this->user_id)?->password,
            ]
        );

        if ($this->role) {
            $user->syncRoles([$this->role]);
        }

        session()->flash('message', $this->user_id ? '✅ User updated successfully.' : '✅ User created successfully.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->role = $user->roles->pluck('name')->first();

        $this->isOpen = true;
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', '🗑️ User deleted successfully.');
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetFields()
    {
        $this->user_id = '';
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
    }
}
