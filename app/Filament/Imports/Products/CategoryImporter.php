<?php

namespace App\Filament\Imports\Products;

use App\Models\Products\Category;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CategoryImporter extends Importer
{
    protected static ?string $model = Category::class;

    public static function getColumns(): array
    {
        return [

            ImportColumn::make('category_index')
                ->requiredMapping()
                ->guess(['Index', 'Šifra'])
                ->rules(['required', 'max:6'])
                ->label('Index'),
            
            ImportColumn::make('category_name')
                ->requiredMapping()
                ->guess(['Naziv', 'Naziv kategorije'])
                ->rules(['required', 'max:100'])
                ->label('Naziv kategorije'),
            
            ImportColumn::make('category_description')
                ->requiredMapping()
                ->guess(['Opis', 'Opis kategorije'])
                ->rules(['required', 'max:500'])
                ->label('Opis kategorije'),

            ImportColumn::make('category_thumbnail')
                ->requiredMapping()
                ->guess(['Slika', 'Slika kategorije'])
                ->rules(['required', 'max:200'])
                ->label('Slika'),

            ImportColumn::make('ordering')
                ->requiredMapping()
                ->guess(['Rb', 'Poredak'])
                ->numeric()
                ->rules(['required', 'integer'])
                ->label('Poredak'),

            ImportColumn::make('created_by')
                ->requiredMapping()
                ->guess(['Kreirao', 'Izradio'])
                ->rules(['required', 'max:6'])
                ->label('Kreirao'),

            ImportColumn::make('updated_by')
                ->requiredMapping()
                ->guess(['Izmjenio', 'Uredio'])
                ->rules(['required', 'max:6'])
                ->label('Izmjenio'),

        ];
    }

    public function resolveRecord(): ?Category
    {
        return Category::firstOrNew([
            'category_index' => $this->data['category_index'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Uvoz kategorija je završen i' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' je uvezeno.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' nije uvezeno.';
        }

        return $body;
    }
}
