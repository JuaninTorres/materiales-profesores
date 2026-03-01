<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Filament\Resources\MaterialResource;
use App\Filament\Widgets\MaterialsStatsWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaterials extends ListRecords
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MaterialsStatsWidget::class,
        ];
    }
}
