<?php

namespace App\Filament\Clusters\Settings\FinanceSettings\Resources\IncotermResource\Pages;

use App\Filament\Clusters\Settings\FinanceSettings\Resources\IncotermResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageIncoterms extends ManageRecords
{
    protected static string $resource = IncotermResource::class;

    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
