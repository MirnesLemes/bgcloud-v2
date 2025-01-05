<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\CoreResource\Pages;

use App\Filament\Clusters\HomeBases\ProductsBase\Resources\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCore extends ViewRecord
{
    protected static string $resource = CoreResource::class;

    protected ?string $heading = 'Pregled proizvoda';

    protected function getHeaderActions(): array
    {
        return [

            Actions\EditAction::make('Izmjena')
                ->label('Izmjena')
                ->icon('heroicon-o-pencil-square'),

            Actions\DeleteAction::make('Brisanje')
                ->label('Brisanje')
                ->icon('heroicon-o-trash'),

            Actions\Action::make('Nazad')
                ->url(CoreResource::getUrl())
                ->icon('heroicon-o-arrow-left-end-on-rectangle'),

        ];
    }

}
