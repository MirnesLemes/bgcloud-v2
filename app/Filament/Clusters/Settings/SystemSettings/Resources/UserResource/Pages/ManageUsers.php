<?php

namespace App\Filament\Clusters\Settings\SystemSettings\Resources\UserResource\Pages;

use App\Filament\Clusters\Settings\SystemSettings\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;
    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
