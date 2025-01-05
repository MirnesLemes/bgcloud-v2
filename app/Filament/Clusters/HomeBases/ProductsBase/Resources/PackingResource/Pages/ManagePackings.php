<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\PackingResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\PackingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Models\Products\Packing;

class ManagePackings extends ManageRecords
{
    protected static string $resource = PackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = Auth::user()->user_index;
                    $data['updated_by'] = Auth::user()->user_index;

                    $max = Packing::max('ordering');
        
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
