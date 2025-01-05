<?php

namespace App\Filament\Resources\Purchases\StockEntries\CoreResource\Pages;

use App\Filament\Resources\Purchases\StockEntries\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCore extends ViewRecord
{
    protected static string $resource = CoreResource::class;

    protected ?string $heading = 'Pregled kalkulacije';

    protected function getHeaderActions(): array
    {
        return [

            Actions\EditAction::make('Izmjena')
                ->label('Izmjena')
                ->disabled(fn ($record) => $record->entry_status)
                ->icon('heroicon-o-pencil-square'),

            Actions\DeleteAction::make('Brisanje')
                ->label('Brisanje')
                ->disabled(fn ($record) => $record->entry_status)
                ->icon('heroicon-o-trash'),

            Actions\Action::make('Nazad')
                ->url(CoreResource::getUrl())
                ->icon('heroicon-o-arrow-left-end-on-rectangle'),

        ];
    }
}
