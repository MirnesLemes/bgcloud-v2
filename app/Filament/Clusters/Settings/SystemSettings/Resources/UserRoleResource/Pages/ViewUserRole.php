<?php

namespace App\Filament\Clusters\Settings\SystemSettings\Resources\UserRoleResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Clusters\Settings\SystemSettings\Resources\UserRoleResource;

class ViewUserRole extends ViewRecord
{
    protected static string $resource = UserRoleResource::class;

    protected ?string $heading = 'Pregled uloge';

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
                ->url(UserRoleResource::getUrl())
                ->icon('heroicon-o-arrow-left-end-on-rectangle'),

        ];
    }
}