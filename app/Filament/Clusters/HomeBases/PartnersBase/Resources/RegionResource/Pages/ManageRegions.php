<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources\RegionResource\Pages;

use Illuminate\Support\Facades\Auth;
use app\Models\Partners\Region;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\RegionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRegions extends ManageRecords
{
    protected static string $resource = RegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = Auth::user()->user_index;
                    $data['updated_by'] = Auth::user()->user_index;

                    $max = Region::max('ordering');
        
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
