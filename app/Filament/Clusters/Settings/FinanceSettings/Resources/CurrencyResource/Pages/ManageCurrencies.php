<?php

namespace App\Filament\Clusters\Settings\FinanceSettings\Resources\CurrencyResource\Pages;

use App\Filament\Clusters\Settings\FinanceSettings\Resources\CurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageCurrencies extends ManageRecords
{
    protected static string $resource = CurrencyResource::class;

    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
