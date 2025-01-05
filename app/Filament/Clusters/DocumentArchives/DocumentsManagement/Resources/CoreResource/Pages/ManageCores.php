<?php

namespace App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources\CoreResource\Pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources\CoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCores extends ManageRecords
{
    protected static string $resource = CoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = Auth::user()->user_index;
                    $data['updated_by'] = Auth::user()->user_index;
                    //$data['document_type'] = Storage::disk('public')->$data['attachment'];

                    return $data;
                })
                ->slideOver(),
        ];
    }
}
