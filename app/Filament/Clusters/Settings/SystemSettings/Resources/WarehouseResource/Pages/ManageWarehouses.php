<?php

namespace App\Filament\Clusters\Settings\SystemSettings\Resources\WarehouseResource\Pages;

use App\Filament\Clusters\Settings\SystemSettings\Resources\WarehouseResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWarehouses extends ManageRecords
{
    protected static string $resource = WarehouseResource::class;
    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
