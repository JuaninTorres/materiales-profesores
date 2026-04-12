<?php

namespace App\Filament\Widgets;

use App\Models\Material;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MaterialsStatsWidget extends BaseWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $total = Material::count();
        $published = Material::where('published', true)->count();
        $unpublished = $total - $published;

        $byLevel = Material::selectRaw('level, count(*) as total')
            ->groupBy('level')
            ->orderByDesc('total')
            ->pluck('total', 'level');

        $levelDescription = $byLevel->isNotEmpty()
            ? $byLevel->map(fn ($n, $lvl) => ucfirst($lvl).': '.$n)->join(' · ')
            : '—';

        $publishedPct = $total > 0 ? round($published / $total * 100) : 0;

        return [
            Stat::make('Total de materiales', $total)
                ->description($levelDescription)
                ->color('primary')
                ->icon('heroicon-o-rectangle-stack'),

            Stat::make('Publicados', $published)
                ->description($publishedPct.'% del total')
                ->color('success')
                ->icon('heroicon-o-eye'),

            Stat::make('Sin publicar', $unpublished)
                ->description($unpublished === 0 ? 'Todo publicado' : 'Pendientes de revisión')
                ->color($unpublished > 0 ? 'warning' : 'success')
                ->icon('heroicon-o-eye-slash'),
        ];
    }
}
