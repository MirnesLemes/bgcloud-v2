<?php

namespace App\Filament\Clusters\Settings\FinanceSettings\Resources\PaymentTermResource\Pages;

use App\Filament\Clusters\Settings\FinanceSettings\Resources\PaymentTermResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManagePaymentTerms extends ManageRecords
{
    protected static string $resource = PaymentTermResource::class;
    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
