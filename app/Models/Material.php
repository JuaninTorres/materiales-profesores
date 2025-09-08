<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory, Searchable;

    protected $fillable = [
        'code','title','description',
        'subject','level','course','year','semester','unit',
        'type','file_path','file_mime','size_kb','link_url','published',
    ];

    protected $casts = [
        'published' => 'boolean',
        'year' => 'integer',
        'semester' => 'integer',
        'size_kb' => 'integer',
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
}
