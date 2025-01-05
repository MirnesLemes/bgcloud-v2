<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\CoreResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCore extends EditRecord
{
    protected static string $resource = CoreResource::class;

    protected ?string $heading = 'Uređivanje proizvoda';

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

        $data['updated_by'] = Auth::user()->user_index;
        return $data; 

    }
}
