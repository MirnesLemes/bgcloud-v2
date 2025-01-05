<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\CoreResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\CoreResource;
use App\Models\Products\Core;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCore extends CreateRecord
{
    protected static string $resource = CoreResource::class; 

    protected ?string $heading = 'Kreiranje proizvoda';

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

            $data['created_by'] = Auth::user()->user_index;
            $data['updated_by'] = Auth::user()->user_index;

            $max = Core::max('ordering');
        
            if (! $max) {
                $data['ordering'] = 1; 
            } else {
                $data['ordering'] = $max + 1;
            }

            return $data;

    }
}
