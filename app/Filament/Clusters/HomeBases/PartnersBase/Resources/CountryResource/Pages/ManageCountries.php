<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources\CountryResource\Pages;

use Illuminate\Support\Facades\Auth;
use app\Models\Partners\Country;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\CountryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCountries extends ManageRecords
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = Auth::user()->user_index;
                    $data['updated_by'] = Auth::user()->user_index;

                    $max = Country::max('ordering');
        
                    if (! $max) {
                        $data['ordering'] = 1; 
                    } else {
                        $data['ordering'] = $max + 1;
                    }

                    return $data;
                })
                ->slideOver(),
        ];
    }
}
