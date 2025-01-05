<?php

namespace App\Filament\Resources\Purchases\Orders\CoreResource\Pages;

use App\Filament\Resources\Purchases\Orders\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCores extends ListRecords
{
    protected static string $resource = CoreResource::class;

    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

}
