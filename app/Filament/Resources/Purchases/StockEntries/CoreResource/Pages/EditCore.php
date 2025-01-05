<?php

namespace App\Filament\Resources\Purchases\StockEntries\CoreResource\Pages;

use App\Filament\Resources\Purchases\StockEntries\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditCore extends EditRecord
{
    protected static string $resource = CoreResource::class;
    protected ?string $heading = 'Izmjena kalkulacije';

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

        $data['entry_index'] = str_pad($data['entry_number'], 6, 0, STR_PAD_LEFT) . '/' . date('Y', strtotime($data['entry_date']));
        $data['entry_week'] = date('W', strtotime($data['entry_date']));
        $data['entry_month'] = date('m', strtotime($data['entry_date']));
        $data['entry_year'] = date('Y', strtotime($data['entry_date']));
        $data['updated_by'] = Auth::user()->user_index;
        return $data;
    }
}
