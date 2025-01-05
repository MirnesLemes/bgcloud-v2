<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\CategoryResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use App\Models\Products\Category;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
