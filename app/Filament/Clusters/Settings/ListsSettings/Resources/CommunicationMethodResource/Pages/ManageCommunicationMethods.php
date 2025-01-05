<?php

namespace App\Filament\Clusters\Settings\ListsSettings\Resources\CommunicationMethodResource\Pages;

use App\Filament\Clusters\Settings\ListsSettings\Resources\CommunicationMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageCommunicationMethods extends ManageRecords
{
    protected static string $resource = CommunicationMethodResource::class;
    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {

        return [
            //
        ];

    }
}
