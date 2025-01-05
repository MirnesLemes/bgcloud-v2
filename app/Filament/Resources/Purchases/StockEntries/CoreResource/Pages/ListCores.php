<?php

namespace App\Filament\Resources\Purchases\StockEntries\CoreResource\Pages;

use App\Filament\Resources\Purchases\StockEntries\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCores extends ListRecords
{
    protected static string $resource = CoreResource::class;

    protected ?string $heading = '';

    protected string $columnSpan = 'full';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
