<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources\CityResource\Pages;

use Illuminate\Support\Facades\Auth;
use app\Models\Partners\City;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\CityResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCities extends ManageRecords
{
    protected static string $resource = CityResource::class;
    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

}
