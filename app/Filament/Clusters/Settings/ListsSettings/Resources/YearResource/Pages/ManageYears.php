<?php

namespace App\Filament\Clusters\Settings\ListsSettings\Resources\YearResource\Pages;

use App\Filament\Clusters\Settings\ListsSettings\Resources\YearResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth; 

class ManageYears extends ManageRecords
{
    protected static string $resource = YearResource::class;
    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
