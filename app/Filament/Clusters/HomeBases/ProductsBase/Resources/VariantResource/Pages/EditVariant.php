<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\VariantResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Models\Products\Core;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\VariantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVariant extends EditRecord
{
    protected static string $resource = VariantResource::class;

    protected ?string $heading = 'Izmjena varijante';

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

        $data['variant_category'] = Core::where('product_index', $data['variant_product'])->first()->product_category;
        $data['variant_brand'] = Core::where('product_index', $data['variant_product'])->first()->product_brand;
        $data['updated_by'] = Auth::user()->user_index;
        return $data; 

    }

}
