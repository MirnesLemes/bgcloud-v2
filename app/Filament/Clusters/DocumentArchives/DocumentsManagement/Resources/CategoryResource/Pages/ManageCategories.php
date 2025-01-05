<?php

namespace App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources\CategoryResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Models\Documents\Category;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = Auth::user()->user_index;
                    $data['updated_by'] = Auth::user()->user_index;
                    
                    $max = Category::max('ordering');

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
