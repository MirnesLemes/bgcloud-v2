<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\BrandResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Models\Products\Brand;

class ManageBrands extends ManageRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = Auth::user()->user_index;
                    $data['updated_by'] = Auth::user()->user_index;
                    
                    $max = Brand::max('ordering');
        
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
