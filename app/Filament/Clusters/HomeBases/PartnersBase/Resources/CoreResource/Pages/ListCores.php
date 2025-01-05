<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources\CoreResource\Pages;

use App\Filament\Clusters\HomeBases\PartnersBase\Resources\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Imports\Partners\CoreImporter as PartnersImporter;
use Filament\Tables\Actions\ImportAction;

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
