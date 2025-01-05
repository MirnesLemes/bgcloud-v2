<?php

namespace App\Filament\Imports\Products;

use App\Models\Products\Variant;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Auth;

class VariantImporter extends Importer
{
    protected static ?string $model = Variant::class;

    public static function getColumns(): array
    {
        return [
            
            ImportColumn::make('variant_index')
                ->requiredMapping()
                ->label('Index')
                ->guess(['Index', 'Index varijante'])
                ->rules(['required', 'max:20']),

            ImportColumn::make('variant_product')
                ->requiredMapping()
                ->label('Proizvod')
                ->guess(['Proizvod', 'Index proizvoda'])
                ->rules(['required', 'max:20']),
            
            ImportColumn::make('variant_category')
                ->requiredMapping()
                ->label('Kategorija')
                ->guess(['Kategorija', 'Index kategorije'])
                ->rules(['required', 'max:6']),

            ImportColumn::make('variant_uom')
                ->requiredMapping()
                ->label('Jm')
                ->guess(['Jm', 'Jedinica mjere'])
                ->rules(['required', 'max:6']),

            ImportColumn::make('variant_packing')
                ->requiredMapping()
                ->label('Pakovanje')
                ->guess(['Pakovanje', 'Nacin pakovanja'])
                ->rules(['required', 'max:6']),

            ImportColumn::make('variant_brand')
                ->requiredMapping()
                ->label('Brend')
                ->guess(['Brend', 'Brand'])
                ->rules(['required', 'max:6']),

            ImportColumn::make('variant_origin')
                ->requiredMapping()
                ->label('Porijeklo')
                ->guess(['Porijeklo', 'Zemlja porijekla'])
                ->rules(['required', 'max:2']),

            ImportColumn::make('variant_code')
                ->requiredMapping()
                ->numeric()
                ->label('Šifra')
                ->guess(['Sifra', 'Sifra varijante'])               
                ->rules(['required', 'integer']),

            ImportColumn::make('variant_name')
                ->requiredMapping()
                ->label('Naziv')
                ->guess(['Naziv', 'Naziv varijante'])
                ->rules(['required', 'max:100']),

            ImportColumn::make('variant_barcode')
                ->label('Barkod')
                ->guess(['Barkod', 'Barcode', 'EAN'])
                ->rules(['max:20']),

            ImportColumn::make('variant_hscode')
                ->label('HS kod')
                ->guess(['HS kod', 'HS code'])
                ->rules(['max:20']),

            ImportColumn::make('uom_quantity')
                ->requiredMapping()
                ->numeric()
                ->label('Kolicina Jm')
                ->guess(['Kolicina Jm', 'Kolicina Jm u pakiranju'])
                ->rules(['required', 'integer']),

            ImportColumn::make('variant_weight')
                ->requiredMapping()
                ->label('Težina')
                ->guess(['Tezina', 'Tezina pakiranja'])    
                ->castStateUsing(function (string $state): ?float {
                    if (blank($state)) {
                        return null;
                    }
                    
                    $state = str_replace(',', '.', $state);
                    $state = floatval($state);
                
                    return round($state, precision: 2);
                })            
                ->rules(['required']),

            ImportColumn::make('variant_price')
                ->requiredMapping()
                ->label('Veleprodajna cijena')
                ->guess(['VPC', 'Veleprodajna cijena'])
                ->castStateUsing(function (string $state): ?float {
                    if (blank($state)) {
                        return null;
                    }
                    
                    $state = str_replace(',', '.', $state);
                    $state = floatval($state);
                
                    return round($state, precision: 2);
                })
                ->rules(['required']),

            ImportColumn::make('variant_taxprice')
                ->requiredMapping()
                ->label('Maloprodajna cijena')
                ->guess(['MPC', 'Maloprodajna cijena'])
                ->castStateUsing(function (string $state): ?float {
                    if (blank($state)) {
                        return null;
                    }
                    
                    $state = str_replace(',', '.', $state);
                    $state = floatval($state);
                
                    return round($state, precision: 2);
                })
                ->rules(['required']),

            ImportColumn::make('variant_expprice')
                ->requiredMapping()
                ->label('Izvozna cijena')
                ->guess(['IZC', 'Izvozna cijena'])
                ->castStateUsing(function (string $state): ?float {
                    if (blank($state)) {
                        return null;
                    }
                    
                    $state = str_replace(',', '.', $state);
                    $state = floatval($state);
                
                    return round($state, precision: 2);
                })
                ->rules(['required']),

            ImportColumn::make('variant_expprice_currency')
                ->requiredMapping()
                ->label('Valuta izvozne cijene')
                ->guess(['IZC valuta', 'Valuta izvozne cijene'])
                ->rules(['required', 'max:3']),

            ImportColumn::make('variant_purprice')
                ->requiredMapping()
                ->label('Nabavna cijena')
                ->guess(['NC', 'Nabavna cijena'])
                ->castStateUsing(function (string $state): ?float {
                    if (blank($state)) {
                        return null;
                    }
                    
                    $state = str_replace(',', '.', $state);
                    $state = floatval($state);
                
                    return round($state, precision: 2);
                })
                ->rules(['required']),

            ImportColumn::make('variant_supprice')
                ->requiredMapping()
                ->label('Cijena dobavljača')
                ->guess(['DBC', 'Cijena dobavljaca'])
                ->castStateUsing(function (string $state): ?float {
                    if (blank($state)) {
                        return null;
                    }
                    
                    $state = str_replace(',', '.', $state);
                    $state = floatval($state);
                
                    return round($state, precision: 2);
                })
                ->rules(['required']),

            ImportColumn::make('variant_supprice_currency')
                ->requiredMapping()
                ->label('Valuta cijene dobavljača')
                ->guess(['DBC valuta', 'Valuta cijene dobavljaca'])
                ->rules(['required', 'max:3']),

            ImportColumn::make('variant_a1_index')
                ->label('Atribut 1')
                ->guess(['Atribut 1', 'Atribut 1 šifra'])
                ->rules(['max:50']),

            ImportColumn::make('variant_a1_value')
                ->label('Vrijednost atributa 1')
                ->guess(['Vrijednost atributa 1', 'Atribut 1 vrijednost'])
                ->rules(['max:200']),

            ImportColumn::make('variant_a2_index')
                ->label('Atribut 2')
                ->guess(['Atribut 2', 'Atribut 2 šifra'])
                ->rules(['max:50']),

            ImportColumn::make('variant_a2_value')
                ->label('Vrijednost atributa 2')
                ->guess(['Vrijednost atributa 2', 'Atribut 2 vrijednost'])
                ->rules(['max:200']),
                
            ImportColumn::make('variant_a3_index')
                ->label('Atribut 3')
                ->guess(['Atribut 3', 'Atribut 3 šifra'])
                ->rules(['max:50']),

            ImportColumn::make('variant_a3_value')
                ->label('Vrijednost atributa 3')
                ->guess(['Vrijednost atributa 3', 'Atribut 3 vrijednost'])
                ->rules(['max:200']),

            ImportColumn::make('variant_a4_index')
                ->label('Atribut 4')
                ->guess(['Atribut 4', 'Atribut 4 šifra'])
                ->rules(['max:50']),

            ImportColumn::make('variant_a4_value')
                ->label('Vrijednost atributa 4')
                ->guess(['Vrijednost atributa 4', 'Atribut 4 vrijednost'])
                ->rules(['max:200']),

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

    public function resolveRecord(): ?Variant
    {
        return Variant::firstOrNew([
            'variant_index' => $this->data['variant_index'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your variant import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
