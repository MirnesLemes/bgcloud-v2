<?php

namespace App\Filament\Clusters\Settings\SystemSettings\Resources\UserRoleResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Clusters\Settings\SystemSettings\Resources\UserRoleResource;

class ListUserRoles extends ListRecords
{
    protected static string $resource = UserRoleResource::class;

    
    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}