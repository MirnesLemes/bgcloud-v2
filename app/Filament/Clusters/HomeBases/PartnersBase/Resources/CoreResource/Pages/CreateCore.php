<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources\CoreResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Models\Partners\Core;
use App\Models\Partners\City;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCore extends CreateRecord
{
    protected static string $resource = CoreResource::class; 

    protected ?string $heading = 'Kreiranje partnera';

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            
            $this->getCreateFormAction()
                ->submit(null)
                ->action('save')
                ->label('Kreiranje')
                ->icon('heroicon-o-plus-circle'),
            
            $this->getCancelFormAction()
                ->label('Odustajanje')
                ->icon('heroicon-o-x-circle')
                ->color('warning'),
        ];
    }
 
    protected function getRedirectUrl(): string
        {
            return $this->getResource()::getUrl('index');
        }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

            $data['partner_country'] = City::where('city_index', $data['partner_city'])->first()->city_country;
            $data['partner_region'] = City::where('city_index', $data['partner_city'])->first()->city_region;
            $data['created_by'] = Auth::user()->user_index;
            $data['updated_by'] = Auth::user()->user_index;

            return $data;

    }
}
