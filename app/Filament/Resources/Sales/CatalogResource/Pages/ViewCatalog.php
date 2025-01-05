<?php

namespace App\Filament\Resources\Sales\CatalogResource\Pages;

use App\Filament\Resources\Sales\CatalogResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCatalog extends ViewRecord
{
    protected static string $resource = CatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\Action::make('Nazad')
                ->url(CatalogResource::getUrl())
                ->icon('heroicon-o-arrow-left-end-on-rectangle'),

        ];
    }
}
