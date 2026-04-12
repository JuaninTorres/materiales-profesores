<?php

namespace App\Livewire\Materials;

use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public string $q = '';

    public ?string $course = null;

    public ?string $unit = null;

    public ?string $tema = null;

    public int $perPage = 12;

    public string $sort = 'recent';      // recent | title_az | title_za

    public string $view = 'cards';       // cards | list

    protected $queryString = [
        'q' => ['except' => ''],
        'course' => ['except' => null],
        'unit' => ['except' => null],
        'tema' => ['except' => null],
        'perPage' => ['except' => 12],
        'sort' => ['except' => 'recent'],
        'view' => ['except' => 'cards'],
        'page' => ['except' => 1],
    ];

    public function updated($field): void
    {
        if (in_array($field, ['q', 'course', 'unit', 'tema', 'perPage', 'sort'])) {
            $this->resetPage();
        }

        if ($field === 'course') {
            $this->unit = null;
            $this->tema = null;
        }

        if ($field === 'unit') {
            $this->tema = null;
        }
    }

    // Helpers para UI
    public function setView(string $mode): void
    {
        $this->view = in_array($mode, ['cards', 'list']) ? $mode : 'cards';
    }

    private function applyFiltersAndSort(Builder $q): Builder
    {
        return $q
            ->when($this->course, fn ($q, $v) => $q->where('course', $v))
            ->when($this->unit, fn ($q, $v) => $q->where('unit', $v))
            ->when($this->tema, fn ($q, $v) => $q->where('tema', $v))
            ->when(true, fn ($q) => match ($this->sort) {
                'title_az' => $q->orderBy('title', 'asc')->orderBy('id', 'desc'),
                'title_za' => $q->orderBy('title', 'desc')->orderBy('id', 'desc'),
                default => $q->latest('id'),
            });
    }

    public function render()
    {
        $term = trim($this->q);

        if ($term !== '') {
            $materials = Material::search($term)
                ->query(fn ($q) => $this->applyFiltersAndSort($q->where('published', true)))
                ->paginate($this->perPage);
        } else {
            $materials = $this->applyFiltersAndSort(
                Material::query()->where('published', true)
            )->paginate($this->perPage);
        }

        // para selects — cada uno se restringe según los filtros upstream activos
        $courses = Material::where('published', true)
            ->select('course')->whereNotNull('course')
            ->distinct()->orderBy('course')->pluck('course');

        $units = Material::where('published', true)
            ->when($this->course, fn ($q) => $q->where('course', $this->course))
            ->select('unit')->whereNotNull('unit')->where('unit', '!=', '')
            ->distinct()->orderBy('unit')->pluck('unit');

        $temas = Material::where('published', true)
            ->when($this->course, fn ($q) => $q->where('course', $this->course))
            ->when($this->unit, fn ($q) => $q->where('unit', $this->unit))
            ->select('tema')->whereNotNull('tema')->where('tema', '!=', '')
            ->distinct()->orderBy('tema')->pluck('tema');

        return view('livewire.materials.index', compact('materials', 'courses', 'units', 'temas'))
            ->layout('layouts.app');
    }
}
