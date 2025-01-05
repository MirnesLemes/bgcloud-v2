<?php

namespace App\Filament\Clusters\Settings\SystemSettings\Resources\UserRoleResource\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Clusters\Settings\SystemSettings\Resources\UserRoleResource;

class EditUserRole extends EditRecord
{
    protected static string $resource = UserRoleResource::class;

    protected ?string $heading = 'Izmjena uloge';

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