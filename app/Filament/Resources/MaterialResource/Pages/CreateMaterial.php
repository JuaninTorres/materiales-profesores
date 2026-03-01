<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Filament\Resources\MaterialResource;
use App\Models\Material;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateMaterial extends CreateRecord
{
    protected static string $resource = MaterialResource::class;

    protected function afterCreate(): void
    {
        $this->updateFileMeta($this->record);
    }

    private function updateFileMeta(Material $record): void
    {
        if (!$record->file_path) return;

        try {
            $disk = Storage::disk('public');
            $record->updateQuietly([
                'file_mime'  => $disk->mimeType($record->file_path) ?? null,
                'size_bytes' => $disk->size($record->file_path) ?? null,
            ]);
        } catch (\Throwable) {
            // El archivo puede no existir aún en casos edge; se ignora.
        }
    }
}
