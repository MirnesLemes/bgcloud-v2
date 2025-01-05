<?php

namespace App\Filament\Exports\Products;

use App\Models\Products\Category;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Builder;

class CategoryExporter extends Exporter
{
    protected static ?string $model = Category::class;

    public static function getColumns(): array
    {
        return [

            ExportColumn::make('category_index')
                ->label('Index'),

            ExportColumn::make('category_name')
                ->label('Naziv kategorije'),

            ExportColumn::make('category_description')
                ->label('Opis kategorije'),

            ExportColumn::make('category_thumbnail')
                ->label('Slika'),

            ExportColumn::make('ordering')
                ->label('Poredak'),

            ExportColumn::make('created_by')
                ->label('Kreirao'),

            ExportColumn::make('updated_by')
                ->label('Izmjenio'),


        ];
    }

    public static function modifyQuery(Builder $query): Builder
    {
        return $query->orderby('ordering');
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Izvoz kategorija je završen i' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' kategorija je izvezeno.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' nije izvezeno.';
        }

        return $body;
    }
}
