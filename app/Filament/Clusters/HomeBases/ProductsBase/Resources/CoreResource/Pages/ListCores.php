<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\CoreResource\Pages;

use App\Filament\Clusters\HomeBases\ProductsBase\Resources\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCores extends ListRecords
{
    protected static string $resource = CoreResource::class;

    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(), 
        ];
    }
}
