<?php

namespace App\Filament\Clusters\Settings\FinanceSettings\Resources\PaymentMethodResource\Pages;

use App\Filament\Clusters\Settings\FinanceSettings\Resources\PaymentMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManagePaymentMethods extends ManageRecords
{
    protected static string $resource = PaymentMethodResource::class;
    protected ?string $heading = '';
    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
