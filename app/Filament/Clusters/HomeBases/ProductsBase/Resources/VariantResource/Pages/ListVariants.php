<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources\VariantResource\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Forms;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\VariantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use Livewire\TemporaryUploadedFile;

class ListVariants extends ListRecords
{
    protected static string $resource = VariantResource::class;
    protected ?string $heading = '';

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),

        ];
    }
}
