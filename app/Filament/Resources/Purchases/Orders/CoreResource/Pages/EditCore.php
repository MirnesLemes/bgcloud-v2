<?php

namespace App\Filament\Resources\Purchases\Orders\CoreResource\Pages;

use App\Filament\Resources\Purchases\Orders\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditCore extends EditRecord
{
    protected static string $resource = CoreResource::class;

    protected ?string $heading = 'Izmjena narudžbe';

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

        $data['order_index'] = str_pad($data['order_number'], 6, 0, STR_PAD_LEFT). '/' . date('Y', strtotime($data['order_date']));
        $data['order_week'] = date('W', strtotime($data['order_date']));
        $data['order_month'] = date('m', strtotime($data['order_date']));
        $data['order_year'] = date('Y', strtotime($data['order_date']));
        $data['updated_by'] = Auth::user()->user_index;
        return $data; 

    }
}
