<?php

namespace App\Filament\Imports\Products;

use App\Models\Products\Core;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CoreImporter extends Importer
{
    protected static ?string $model = Core::class;

    public static function getColumns(): array
    {
        return [

            ImportColumn::make('product_index')
                ->requiredMapping()
                ->guess(['Index', 'Šifra'])
                ->rules(['required', 'max:20'])
                ->label('Index'),
            
            ImportColumn::make('product_category')
                ->requiredMapping()
                ->guess(['Kategorija', 'Šifra kategorije'])
                ->rules(['required', 'max:6'])
                ->label('Kategorija'),
            
            ImportColumn::make('product_brand')
                ->requiredMapping()
                ->guess(['Brend', 'Šifra brenda'])
                ->rules(['required', 'max:6'])
                ->label('Brend'),

            ImportColumn::make('product_name')
                ->requiredMapping()
                ->guess(['Naziv', 'Naziv proizvoda'])
                ->rules(['required', 'max:100'])
                ->label('Naziv proizvoda'),

            ImportColumn::make('product_description')
                ->requiredMapping()
                ->guess(['Opis', 'Opis proizvoda'])
                ->rules(['required', 'max:500'])
                ->label('Opis proizvoda'),

            ImportColumn::make('product_text')
                ->requiredMapping()
                ->guess(['Tekst', 'Tekst o proizvodu'])
                ->rules(['required'])
                ->label('Tekst o proizvodu'),

            ImportColumn::make('product_tags')
                ->requiredMapping()
                ->guess(['Oznake', 'Oznake proizvoda'])
                ->rules(['required'])
                ->label('Oznake proizvoda'),

            ImportColumn::make('product_thumbnail')
                ->guess(['Slika', 'Slika proizvoda'])
                ->rules(['max:200'])
                ->label('Slika proizvoda'),

            ImportColumn::make('product_video')
                ->guess(['Video', 'Youtube video'])
                ->rules(['max:200'])
                ->label('Youtube video'),
            
            ImportColumn::make('product_a1_name')
                ->guess(['Atribut 1', 'Naziv atributa 1'])
                ->rules(['max:50'])
                ->label('Naziv atributa 1'),
            
            ImportColumn::make('product_a2_name')
                ->guess(['Atribut 2', 'Naziv atributa 2'])
                ->rules(['max:50'])
                ->label('Naziv atributa 2'),

            ImportColumn::make('product_a3_name')
                ->guess(['Atribut 3', 'Naziv atributa 3'])
                ->rules(['max:50'])
                ->label('Naziv atributa 3'),

            ImportColumn::make('product_a4_name')
                ->guess(['Atribut 4', 'Naziv atributa 4'])
                ->rules(['max:50'])
                ->label('Naziv atributa 4'),

            ImportColumn::make('product_a1_values')
                ->guess(['Vrijednosti atributa 1'])
                ->rules(['max:500'])
                ->label('Vrijednosti atributa 1'),

            ImportColumn::make('product_a2_values')
                ->guess(['Vrijednosti atributa 2'])
                ->rules(['max:500'])
                ->label('Vrijednosti atributa 2'),

            ImportColumn::make('product_a3_values')
                ->guess(['Vrijednosti atributa 3'])
                ->rules(['max:500'])
                ->label('Vrijednosti atributa 3'),

            ImportColumn::make('product_a4_values')
                ->guess(['Vrijednosti atributa 4'])
                ->rules(['max:500'])
                ->label('Vrijednosti atributa 4'),

            ImportColumn::make('published')
                ->guess(['Objavljen'])
                ->label('Objavljen'),

            ImportColumn::make('featured')
                ->guess(['Izdvojen'])
                ->label('Izdvojen'),

            ImportColumn::make('onsale')
                ->guess(['Rasprodaja'])
                ->label('Rasprodaja'),

            ImportColumn::make('ordering')
                ->guess(['Rb', 'Poredak'])
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer'])
                ->label('Redoslijed'),

            ImportColumn::make('created_by')
                ->guess(['Kreirao', 'Izradio'])
                ->requiredMapping()
                ->rules(['required', 'max:6'])
                ->label('Izradio'),

            ImportColumn::make('updated_by')
                ->guess(['Izmjenio', 'Uredio'])
                ->requiredMapping()
                ->rules(['required', 'max:6'])
                ->label('Izmjenio'),

        ];
    }

    public function resolveRecord(): ?Core
    {
        return Core::firstOrNew([
            'product_index' => $this->data['product_index'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Uvoz proizvoda je završen i' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' je uvezeno.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' nije uvezeno.';
        }

        return $body;
    }
}
