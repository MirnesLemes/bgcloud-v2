<?php

namespace App\Filament\Imports\Partners;

use App\Models\Partners\Contact;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ContactImporter extends Importer
{
    protected static ?string $model = Contact::class;

    public static function getColumns(): array
    {
        return [

            ImportColumn::make('contact_id')
                ->requiredMapping()
                ->guess(['Id', 'Id broj'])
                ->label('Id')
                ->exampleHeader('Id'),

            ImportColumn::make('contact_partner')
                ->requiredMapping()
                ->guess(['Partner', 'Šifra partnera'])
                ->rules(['required', 'integer'])
                ->label('Šifra partnera')
                ->exampleHeader('Šifra partnera'),

            ImportColumn::make('contact_name')
                ->requiredMapping()
                ->guess(['Ime kontakta', 'Naziv kontakta'])
                ->rules(['required', 'max:50'])
                ->label('Ime kontakta')
                ->exampleHeader('Ime kontakta'),

            ImportColumn::make('contact_workplace')
                ->requiredMapping()
                ->guess(['Radno mjesto', 'Funkcija'])
                ->rules(['required', 'max:50'])
                ->label('Radno mjesto')
                ->exampleHeader('Radno mjesto'),

            ImportColumn::make('contact_phone')
                ->requiredMapping()
                ->guess(['Telefon', 'Kontakt telefon'])
                ->rules(['required', 'max:30'])
                ->label('Telefon')
                ->exampleHeader('Telefon'),

            ImportColumn::make('contact_mobile')
                ->requiredMapping()
                ->guess(['Mobitel', 'Kontakt mobitel'])
                ->rules(['required', 'max:30'])
                ->label('Mobitel')
                ->exampleHeader('Mobitel'),

            ImportColumn::make('contact_mail')
                ->requiredMapping()
                ->guess(['E-mail', 'Kontakt e-mail'])
                ->rules(['required', 'max:50'])
                ->label('E-mail')
                ->exampleHeader('E-mail'),

            ImportColumn::make('ordering')
                ->requiredMapping()
                ->guess(['Poredak', 'Sortiranje'])
                ->rules(['required', 'integer'])
                ->label('Poredak')
                ->exampleHeader('Poredak'),

            ImportColumn::make('created_by')
                ->requiredMapping()
                ->guess(['Kreirao', 'Šifra autora'])
                ->rules(['required', 'max:6'])
                ->label('Kreirao')
                ->exampleHeader('Keirao'),

            ImportColumn::make('updated_by')
                ->requiredMapping()
                ->guess(['Izmjenio', 'Šifra editora'])
                ->rules(['required', 'max:6'])
                ->label('Izmjenio')
                ->exampleHeader('Izmjenio'),

        ];
    }

    public function resolveRecord(): ?Contact
    {
        return Contact::firstOrNew([
            'contact_id' => $this->data['contact_id'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Uvoz kontakt podataka je završen i ' . number_format($import->successful_rows) . ' redova je uvezeno.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' redova nije uvezeno.';
        }

        return $body;
    }
}
