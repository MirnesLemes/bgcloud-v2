<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources\CoreResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Models\Partners\City;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditCore extends EditRecord
{
    protected static string $resource = CoreResource::class;

    protected ?string $heading = 'Izmjena partnera';

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->submit(null)
                ->action('save')
                ->label('Spremanje')
                ->icon('heroicon-o-check-circle'),
            
                $this->getCancelFormAction()
                ->label('Odustajanje')
                ->icon('heroicon-o-x-circle')
                ->color('warning'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {

        $data['partner_country'] = City::where('city_index', $data['partner_city'])->first()->city_country;
        $data['partner_region'] = City::where('city_index', $data['partner_city'])->first()->city_region;
        $data['updated_by'] = Auth::user()->user_index;
        return $data; 

    }
}
