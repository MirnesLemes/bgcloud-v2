<?php

namespace App\Filament\Clusters\Settings\FinanceSettings\Resources\TaxResource\Pages;

use App\Filament\Clusters\Settings\FinanceSettings\Resources\TaxResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageTaxes extends ManageRecords
{
    protected static string $resource = TaxResource::class;
    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];

    }
}
