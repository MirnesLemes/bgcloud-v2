<?php

namespace App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources\DoctypeResource\Pages;

use App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources\DoctypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageDoctypes extends ManageRecords
{
    protected static string $resource = DoctypeResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\CreateAction::make()

                ->mutateFormDataUsing(function (array $data): array {

                    $data['ordering'] = nextNumber('ordering', 'system_document_types');
                    $data['created_by'] = Auth::user()->user_index;
                    $data['updated_by'] = Auth::user()->user_index;
                    return $data;
                
                })
            ->slideOver(),

        ];
    }
}
