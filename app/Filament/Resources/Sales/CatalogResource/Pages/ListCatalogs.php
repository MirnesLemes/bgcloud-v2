<?php

namespace App\Filament\Resources\Sales\CatalogResource\Pages;

use App\Filament\Resources\Sales\CatalogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatalogs extends ListRecords
{
    protected static string $resource = CatalogResource::class;

    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(), 
        ];
    }


}
