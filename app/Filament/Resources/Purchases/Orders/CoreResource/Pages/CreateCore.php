<?php

namespace App\Filament\Resources\Purchases\Orders\CoreResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\Purchases\Orders\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
//use Illuminate\Support\Str;

class CreateCore extends CreateRecord
{
    protected static string $resource = CoreResource::class;

    protected ?string $heading = 'Kreiranje narudžbe';

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
            $orderIndex = str_pad($data['order_number'], 6, 0, STR_PAD_LEFT). '/' . date('Y', strtotime($data['order_date']));
            $orderWeek = date('W', strtotime($data['order_date']));
            $orderMonth = date('m', strtotime($data['order_date']));
            $orderYear = date('Y', strtotime($data['order_date']));
        
            //$data['order_id'] = Str::uuid();
            $data['order_index'] = $orderIndex;
            $data['order_amount'] = 0;
            $data['order_currency_rate'] = 0;
            $data['order_status'] = 'NAC';
            $data['order_doctype'] = 'NRD';
            $data['order_week'] = $orderWeek;
            $data['order_month'] = $orderMonth;
            $data['order_year'] = $orderYear;
            $data['created_by'] = Auth::user()->user_index;
            $data['updated_by'] = Auth::user()->user_index;

            return $data;

    }
}
