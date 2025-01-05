<?php

namespace App\Filament\Clusters\Settings\ListsSettings\Resources\MonthResource\Pages;

use App\Filament\Clusters\Settings\ListsSettings\Resources\MonthResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth; 

class ManageMonths extends ManageRecords
{
    protected static string $resource = MonthResource::class;
    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
