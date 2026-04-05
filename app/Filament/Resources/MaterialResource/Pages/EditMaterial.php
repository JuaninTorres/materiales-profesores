<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Filament\Resources\MaterialResource;
use App\Models\Material;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditMaterial extends EditRecord
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->updateFileMeta($this->record);
    }

    private function updateFileMeta(Material $record): void
    {
        if (! $record->file_path) {
            return;
        }

        try {
            $disk = Storage::disk('public');
            $record->updateQuietly([
                'file_mime' => $disk->mimeType($record->file_path) ?? null,
                'size_bytes' => $disk->size($record->file_path) ?? null,
            ]);
        } catch (\Throwable) {
            // El archivo puede no existir; se ignora.
        }
    }
}
