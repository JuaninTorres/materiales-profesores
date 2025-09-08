<?php

namespace App\Livewire\Materials;

use App\Models\Material;
use Livewire\Component;

class Show extends Component
{
    public Material $material;

    public function mount(Material $material) { $this->material = $material; }

    public function render()
    {
        return view('livewire.materials.show')
            ->title($this->material->title)
            ->layout('layouts.app'); // <- usa el layout aquí también
    }
}
