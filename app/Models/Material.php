<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Illuminate\Database\Eloquent\Builder;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory, Searchable;

    protected $fillable = [
        'code','title','description',
        'subject','level','course','year','semester','unit',
        'type','file_path','file_mime','size_bytes','link_url','published','tags',
    ];

    protected $casts = [
        'published' => 'boolean',
        'year' => 'integer',
        'semester' => 'integer',
        'size_bytes' => 'integer',
        'tags' => 'array',
    ];

    // Para usar {material:code} en las rutas
    public function getRouteKeyName(): string
    {
        return 'code';
    }

    // Estrategia de búsqueda con Scout Database Engine
    #[SearchUsingPrefix(['code'])] // búsqueda rápida por prefijo del código
    #[SearchUsingFullText(['title','description','subject','course','unit'])] // usa índices FULLTEXT
    public function toSearchableArray(): array
    {
        return [
            'code'        => $this->code,
            'title'       => $this->title,
            'description' => $this->description,
            'subject'     => $this->subject,
            'level'       => $this->level,
            'course'      => $this->course,
            'year'        => $this->year,
            'semester'    => $this->semester,
            'unit'        => $this->unit,
            'type'        => $this->type,
        ];
    }

    protected function getSizeFormattedAttribute(): ?string
    {
        if (!$this->size_bytes) return null;

        if ($this->size_bytes < 1024) return $this->size_bytes . ' B';
        if ($this->size_bytes < 1048576) return number_format($this->size_bytes / 1024, 1) . ' KB';
        return number_format($this->size_bytes / 1048576, 2) . ' MB';
    }

    protected function getTipoAttribute()
    {
        if($this->type == 'html'){
            return 'Presentación HTML';
        }

        if($this->type == 'other'){
            return 'Otros';
        }

        if($this->type == 'pdf'){
            return 'PDF';
        }

        return ucfirst($this->type);
    }

    protected function getNivelAttribute()
    {
        if($this->level == 'cft') {
            return '<span class="badge text-bg-primary">' . strtoupper($this->level) . '</span>';
        }

        if($this->level == 'colegio') {
            return '<span class="badge text-bg-warning">' . strtoupper($this->level) . '</span>';
        }

        if($this->level == 'particulares') {
            return '<span class="badge text-bg-success">' . strtoupper($this->level) . '</span>';
        }

        return '<span class="badge text-bg-info">' . strtoupper($this->level) . '</span>';
    }

}
