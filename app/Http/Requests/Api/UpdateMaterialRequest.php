<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => 'sometimes|required|string|max:255',
            'description'  => 'nullable|string',
            'subject'      => 'sometimes|required|string|max:255',
            'level'        => 'sometimes|required|in:colegio,cft,particulares,universidad,instituto',
            'course'       => 'nullable|string|max:255',
            'year'         => 'nullable|integer|min:2020|max:2099',
            'semester'     => 'nullable|integer|min:1|max:2',
            'unit'         => 'nullable|string|max:255',
            'tags'         => 'nullable|array',
            'tags.*'       => 'string|max:100',
            'archivo_html' => 'nullable|file|mimetypes:text/html,text/plain|max:10240',
        ];
    }
}
