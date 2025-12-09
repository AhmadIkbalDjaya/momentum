<?php

namespace App\Livewire\Components;

use Livewire\Component;

class InputErrorMessage extends Component
{
    public $field;

    public function render()
    {
        return view('livewire.components.input-error-message');
    }
}
