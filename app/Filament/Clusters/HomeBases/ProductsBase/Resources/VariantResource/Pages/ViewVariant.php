<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\VariantResource\Pages;

use App\Filament\Clusters\HomeBases\ProductsBase\Resources\VariantResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVariant extends ViewRecord
{
    protected static string $resource = VariantResource::class;

    protected ?string $heading = 'Pregled varijante';

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
                ->url(VariantResource::getUrl())
                ->icon('heroicon-o-arrow-left-end-on-rectangle'),

        ];
    }
}
