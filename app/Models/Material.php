<?php

namespace App\Models;

use Database\Factories\MaterialFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Material extends Model
{
    /** @use HasFactory<MaterialFactory> */
    use HasFactory, Searchable;

    protected $fillable = [
        'code', 'title', 'description',
        'subject', 'level', 'course', 'year', 'semester', 'unit', 'tema',
        'type', 'file_path', 'file_mime', 'size_bytes', 'link_url', 'published', 'tags',
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

    public function shouldBeSearchable(): bool
    {
        return (bool) $this->published;
    }

    public function toSearchableArray(): array
    {
        return [
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'subject' => $this->subject,
            'level' => $this->level,
            'course' => $this->course,
            'year' => $this->year,
            'semester' => $this->semester,
            'unit' => $this->unit,
            'type' => $this->type,
        ];
    }

    protected function sizeFormatted(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if (! $this->size_bytes) {
                    return null;
                }
                if ($this->size_bytes < 1024) {
                    return $this->size_bytes.' B';
                }
                if ($this->size_bytes < 1048576) {
                    return number_format($this->size_bytes / 1024, 1).' KB';
                }

                return number_format($this->size_bytes / 1048576, 2).' MB';
            }
        );
    }

    protected function tipo(): Attribute
    {
        return Attribute::make(
            get: fn (): string => match ($this->type) {
                'html' => 'Presentación HTML',
                'other' => 'Otros',
                'pdf' => 'PDF',
                default => ucfirst($this->type),
            }
        );
    }

    protected function nivel(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $map = [
                    'colegio' => ['text-bg-warning',  'Colegio'],
                    'cft' => ['text-bg-primary',   'CFT'],
                    'particulares' => ['text-bg-success',   'Particulares'],
                    'universidad' => ['text-bg-danger',    'Universidad'],
                    'instituto' => ['text-bg-secondary', 'Instituto'],
                ];
                [$class, $label] = $map[$this->level] ?? ['text-bg-info', strtoupper($this->level)];

                return '<span class="badge '.$class.'">'.$label.'</span>';
            }
        );
    }
}
