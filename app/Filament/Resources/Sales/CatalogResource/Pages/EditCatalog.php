<?php

namespace App\Filament\Resources\Sales\CatalogResource\Pages;

use App\Filament\Resources\Sales\CatalogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatalog extends EditRecord
{
    protected static string $resource = CatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
