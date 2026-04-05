<?php

namespace App\Services;

use App\Filament\Resources\MaterialResource;
use App\Models\Material;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MaterialService
{
    /**
     * Crea un nuevo Material a partir de los datos validados y el archivo HTML.
     * Replica exactamente la lógica de CreateMaterial (Filament).
     */
    public function store(array $data, UploadedFile $file): Material
    {
        $directory = 'materials/'.now()->format('Y/m');
        $filePath = $file->store($directory, 'public');

        $data['file_path'] = $filePath;
        $data['file_mime'] = $file->getMimeType();
        $data['size_bytes'] = $file->getSize();

        if (empty($data['code'])) {
            $data['code'] = MaterialResource::generateUniqueCode($data);
        }

        return Material::create($data);
    }

    /**
     * Actualiza un Material existente.
     * Si se provee un nuevo archivo HTML, reemplaza el anterior y recalcula metadatos.
     * Replica exactamente la lógica de EditMaterial (Filament).
     */
    public function update(Material $material, array $data, ?UploadedFile $file): Material
    {
        if ($file !== null) {
            // Eliminar el archivo anterior si existe
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }

            $directory = 'materials/'.now()->format('Y/m');
            $filePath = $file->store($directory, 'public');

            $data['file_path'] = $filePath;
            $data['file_mime'] = $file->getMimeType();
            $data['size_bytes'] = $file->getSize();
        }

        $material->update($data);

        return $material->fresh();
    }
}
