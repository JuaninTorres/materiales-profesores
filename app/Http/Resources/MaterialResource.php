<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MaterialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
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
            'tags'        => $this->tags ?? [],
            'size_bytes'  => $this->size_bytes,
            'published'   => $this->published,
            'url'         => route('materials.show', $this->code),
            'file_url'    => $this->file_path
                                ? Storage::disk('public')->url($this->file_path)
                                : null,
            'created_at'  => $this->created_at->toIso8601String(),
            'updated_at'  => $this->updated_at->toIso8601String(),
        ];
    }
}
