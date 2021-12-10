<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;


class UserIndex extends Component
{
    use WithPagination;
        protected $paginationTheme = 'bootstrap';

    public $search='';
    public $username,$firstName,$lastName,$email,$password ;
    public $userId;
    public $editMode=false;

    protected $rules = [
        'username'  => 'required',
        'firstName' => 'required',
        'lastName'  => 'required',
        'password'  => 'required',
        'email'     => 'required|email',
    ];

    public function showEditModal($id)
    {
        $this->reset();
        $this->editMode=true;
        //find
        $this->userId=$id;
        //load
        $this->loadUser();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#usermodal', 'actionModal' => 'show']);
    }
    public function showUserModal()
    {
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#usermodal', 'actionModal' => 'show']);
    }

    public function storeUser()
    {
        $this->validate();
        User::create([
            'username'  => $this->username,
            'first_name'=> $this->firstName,
            'last_name' => $this->lastName,
            'password'  => Hash::make($this->password),
            'email'     => $this->email,
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('modal',['modalId'=>'#usermodal','actionModal'=>'hide']);
        session()->flash('user_message', 'Post successfully created.');
    }

    public function updateUser()
    {
       $validated = $this->validate([
           'username'  => 'required',
           'firstName' => 'required',
           'lastName'  => 'required',
           'email'     => 'required|email',
           ]);
        $user=User::find($this->userId);
        $user->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('modal', ['modalId' => '#usermodal', 'actionModal' => 'hide']);
        session()->flash('user_message', 'Post successfully updated.');
    }
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        session()->flash('user_message', 'Post successfully deleted.');
    }

    public function closeModal()
    {
        $this->dispatchBrowserEvent('modal', ['modalId' => '#usermodal', 'actionModal' => 'hide']);
    }

    public function loadUser()
    {
        $user=User::find($this->userId);
        $this->username = $user->username;
        $this->firstName = $user->first_name;
        $this->lastName = $user->last_name;
        $this->email = $user->email;

    }

    public function render()
    {
        $users = User::paginate(5);
        if(strlen($this->search) > 2){

            $users= User::where('username', 'like', "%{$this->search}%")->paginate(5);
        }

        return view('livewire.users.user-index',
            ['users'=>$users])
        ->layout('layouts.main');
    }
}
