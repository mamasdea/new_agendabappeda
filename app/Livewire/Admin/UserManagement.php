<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
#[Title('Manajemen User - Admin Panel')]
class UserManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $userId;
    public $name, $username, $email, $password;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'nullable|email|max:255|unique:users,email',
        'password' => 'required|min:6',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetInput()
    {
        $this->userId = null;
        $this->name = '';
        $this->username = '';
        $this->email = '';
        $this->password = '';
        $this->isEdit = false;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('success', 'User berhasil ditambahkan.');
        $this->resetInput();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $this->resetInput();
        $this->isEdit = true;
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        
        $this->dispatch('open-modal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $this->userId,
            'email' => 'nullable|email|max:255|unique:users,email,' . $this->userId,
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($this->userId);
        $data = [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        session()->flash('success', 'User berhasil diperbarui.');
        $this->resetInput();
        $this->dispatch('close-modal');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus diri sendiri.');
            return;
        }

        $user->delete();
        session()->flash('success', 'User berhasil dihapus.');
    }

    public function render()
    {
        $users = User::where(function($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('username', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->paginate(10);

        return view('livewire.admin.user-management', [
            'users' => $users
        ]);
    }
}
