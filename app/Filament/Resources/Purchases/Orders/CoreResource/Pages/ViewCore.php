<?php

namespace App\Filament\Resources\Purchases\Orders\CoreResource\Pages;

use App\Filament\Resources\Purchases\Orders\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCore extends ViewRecord
{
    protected static string $resource = CoreResource::class;

    protected ?string $heading = 'Pregled narudžbe';

    protected function getHeaderActions(): array
    {
        return [

            Actions\EditAction::make('Izmjena')
                ->label('Izmjena')
                ->disabled(true)
                ->icon('heroicon-o-pencil-square'),

            Actions\DeleteAction::make('Brisanje')
                ->label('Brisanje')
                ->disabled(true)
                ->icon('heroicon-o-trash'),

            Actions\Action::make('Nazad')
                ->url(CoreResource::getUrl())
                ->icon('heroicon-o-arrow-left-end-on-rectangle'),

        ];
    }
}
