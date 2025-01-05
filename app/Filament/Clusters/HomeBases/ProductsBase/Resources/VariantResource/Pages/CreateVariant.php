<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\VariantResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Models\Products\Core;
use App\Models\Products\Variant;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\VariantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVariant extends CreateRecord 
{
    protected static string $resource = VariantResource::class;

    protected ?string $heading = 'Kreiranje varijante';

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            
            $this->getCreateFormAction()
                ->submit(null)
                ->action('create')
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
        
            $data['variant_category'] = Core::where('product_index', $data['variant_product'])->first()->product_category;
            $data['variant_brand'] = Core::where('product_index', $data['variant_product'])->first()->product_brand;
            $data['created_by'] = Auth::user()->user_index;
            $data['updated_by'] = Auth::user()->user_index;

            $max = Variant::max('ordering');
        
            if (! $max) {
                $data['ordering'] = 1; 
            } else {
                $data['ordering'] = $max + 1;
            }

            return $data;

    }

}
