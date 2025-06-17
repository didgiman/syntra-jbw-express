<?php

namespace App\Livewire;

use App\Models\ContactMessage;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required')]
    public $name = '';

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $subject = '';

    #[Validate('required')]
    public $message = '';

    public function save()
    {
        $this->validate();
        ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);
        session()->flash('status', 'Your email has been sent!');
        return redirect()->route('contact');
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
