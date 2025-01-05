<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\UomResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\UomResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Models\Products\Uom;

class ManageUoms extends ManageRecords
{
    protected static string $resource = UomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = Auth::user()->user_index;
                    $data['updated_by'] = Auth::user()->user_index;

                    $max = Uom::max('ordering');
        
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
