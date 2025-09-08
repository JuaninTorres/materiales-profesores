<?php

namespace App\Livewire\Materials;

use App\Models\Material;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url] public string $q = '';
    #[Url] public ?string $level = null;
    #[Url] public ?string $subject = null;
    #[Url] public ?string $course = null;
    #[Url] public ?int $year = null;
    #[Url] public ?int $semester = null;

    public function updating($name, $value) { $this->resetPage(); }

    public function render()
    {
        if (trim($this->q) !== '') {
            $ids = Material::search($this->q)->keys();
            $query = Material::whereIn('id', $ids);
        } else {
            $query = Material::query();
        }

        $query->where('published', true)
              ->when($this->level, fn($q) => $q->where('level', $this->level))
              ->when($this->subject, fn($q) => $q->where('subject', $this->subject))
              ->when($this->course, fn($q) => $q->where('course', $this->course))
              ->when($this->year, fn($q) => $q->where('year', $this->year))
              ->when($this->semester, fn($q) => $q->where('semester', $this->semester))
              ->latest();

        $materials = $query->paginate(12);

        return view('livewire.materials.index', compact('materials'))
            ->title('Materiales')
            ->layout('layouts.app'); // <- usa el layout aquí
    }
}
