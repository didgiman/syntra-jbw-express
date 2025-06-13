<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Validate;

class UserSearch extends Component
{
    #[Validate('required|min:2')]
    public $name = '';
    public $results = [];

    #[Validate('required')]
    public User $user;

    public $buttonText = 'Select';
    public $onSelect = 'user-selected';

    public function mount($buttonText = 'Select', $onSelect = null)
    {
        if (isset($buttonText) && $buttonText !== '') {
            $this->buttonText = $buttonText;
        }
        if (isset($onSelect) && $onSelect !== '') {
            $this->onSelect = $onSelect;
        }
    }

    public function updatedName($value)
    {
        $this->reset('results', 'user');

        $this->validate([
            'name' => 'required|min:2'
        ]);

        $searchTerm = "%{$value}%";

        $this->results = User::where('name', 'LIKE', $searchTerm)->get();
    }

    public function found(User $user)
    {
        $this->user = $user;
        $this->name = $this->user->name;

        $this->reset('results');
    }

    public function select()
    {
        $this->validate();
        
        $this->dispatch($this->onSelect, user: $this->user);

        $this->resetExcept('buttonText', 'onSelect');
    }

    public function render()
    {
        return view('livewire.user-search');
    }
}
