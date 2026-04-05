<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // La autenticación la garantiza el middleware auth:sanctum
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:255',
            'level' => 'required|in:colegio,cft,particulares,universidad,instituto',
            'course' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:2020|max:2099',
            'semester' => 'nullable|integer|min:1|max:2',
            'unit' => 'nullable|string|max:255',
            'type' => 'required|in:html',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:100',
            'archivo_html' => 'required|file|mimetypes:text/html,text/plain|max:10240',
        ];
    }
}
