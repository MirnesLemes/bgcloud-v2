<?php

namespace App\Filament\Resources\Purchases\StockEntries\CoreResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\Purchases\StockEntries\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCore extends CreateRecord
{
    protected static string $resource = CoreResource::class;

    protected ?string $heading = 'Kreiranje kalkulacije';

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
            $entryIndex = str_pad($data['entry_number'], 6, 0, STR_PAD_LEFT). '/' . date('Y', strtotime($data['entry_date']));
            $entryWeek = date('W', strtotime($data['entry_date']));
            $entryMonth = date('m', strtotime($data['entry_date']));
            $entryYear = date('Y', strtotime($data['entry_date']));
        
            //$data['order_id'] = Str::uuid();
            $data['entry_index'] = $entryIndex;
            $data['entry_invoice_amount'] = 0;
            $data['entry_converted_amount'] = 0;
            $data['entry_cost_amount'] = 0;
            $data['entry_purchase_amount'] = 0;
            $data['entry_tax_amount'] = 0;
            $data['entry_margin_amount'] = 0;
            $data['entry_sale_amount'] = 0;
            $data['entry_status'] = 0;
            $data['entry_doctype'] = 'ULK';
            $data['entry_week'] = $entryWeek;
            $data['entry_month'] = $entryMonth;
            $data['entry_year'] = $entryYear;
            $data['created_by'] = Auth::user()->user_index;
            $data['updated_by'] = Auth::user()->user_index;

            return $data;

    }
}
