<?php

namespace App\Filament\Clusters\Settings\ListsSettings\Resources\RatingResource\Pages;

use App\Filament\Clusters\Settings\ListsSettings\Resources\RatingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth; 

class ManageRatings extends ManageRecords
{
    protected static string $resource = RatingResource::class;
    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
