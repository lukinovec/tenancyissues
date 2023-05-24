<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Testing extends Component
{
    public $message;

    public function render()
    {
        return view('livewire.testing');
    }
}
