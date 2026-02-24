<?php
namespace App\Livewire\Materials;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Material;

class Index extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    // Estado existente
    public string $q = '';
    public ?string $course = null;
    public ?string $type = null;
    public ?string $semester = null;
    public int $perPage = 12;

    // NUEVO: orden y vista
    public string $sort = 'recent';      // recent | title_az | title_za
    public string $view = 'cards';       // cards | list

    // Mantener en la URL
    protected $queryString = [
        'q' => ['except' => ''],
        'course' => ['except' => null],
        'type' => ['except' => null],
        'semester' => ['except' => null],
        'perPage' => ['except' => 12],
        'sort' => ['except' => 'recent'],
        'view' => ['except' => 'cards'],
        'page' => ['except' => 1],
    ];

    public function updated($field): void
    {
        if (in_array($field, ['q','course','type','semester','perPage','sort'])) {
            $this->resetPage();
        }
    }

    // Helpers para UI
    public function setView(string $mode): void
    {
        $this->view = in_array($mode, ['cards','list']) ? $mode : 'cards';
    }

    public function render()
    {
        $materials = Material::query()
            ->where('published', true)
            ->when(trim($this->q) !== '', function ($q) {
                $term = trim($this->q);
                $q->where(fn($w) =>
                    $w->where('title','like',"%{$term}%")
                      ->orWhere('course','like',"%{$term}%")
                      ->orWhere('type','like',"%{$term}%")
                      ->orWhere('description','like',"%{$term}%")
                );
            })
            ->when($this->course,  fn($q,$v) => $q->where('course',$v))
            ->when($this->type,    fn($q,$v) => $q->where('type',$v))
            ->when($this->semester,fn($q,$v) => $q->where('semester',$v))

            // ORDENAMIENTO
            ->when(true, function($q) {
                return match($this->sort) {
                    'title_az' => $q->orderBy('title','asc')->orderBy('id','desc'),
                    'title_za' => $q->orderBy('title','desc')->orderBy('id','desc'),
                    default    => $q->latest('id'), // recent
                };
            })
            ->paginate($this->perPage);

        // para selects
        $courses   = Material::where('published', true)->select('course')->distinct()->orderBy('course')->pluck('course');
        $types     = Material::where('published', true)->select('type')->distinct()->orderBy('type')->pluck('type');
        $semesters = Material::where('published', true)->select('semester')->whereNotNull('semester')->distinct()->orderBy('semester','desc')->pluck('semester');

        return view('livewire.materials.index', compact('materials','courses','types','semesters'))
            ->layout('layouts.app');
    }
}
