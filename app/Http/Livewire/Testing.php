<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class Testing extends Component
{
    use WithFileUploads;

    public string $text = '';

    public $photo;

    public function save()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        $this->photo->store('photos');
    }

    public function render()
    {
        return view('livewire.testing');
    }
}
