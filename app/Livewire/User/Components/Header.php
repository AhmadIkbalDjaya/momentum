<?php

namespace App\Livewire\User\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        return view('livewire.user.components.header');
    }

    public function logout()
    {
        Auth::guard('student')->logout();

        return $this->redirectRoute('login', navigate: true);
    }
}
