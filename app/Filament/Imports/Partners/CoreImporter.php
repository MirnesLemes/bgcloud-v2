<?php

namespace App\Filament\Imports\Partners;

use App\Models\Partners\Core;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class CoreImporter extends Importer
{
    protected static ?string $model = Core::class;

    public static function getColumns(): array
    {
        return [

            ImportColumn::make('partner_index')
                ->requiredMapping()
                ->guess(['Index', 'Šifra'])
                ->rules(['required', 'integer'])
                ->label('Index')
                ->exampleHeader('Šifra'),

            ImportColumn::make('partner_name')
                ->requiredMapping()
                ->guess(['Naziv', 'Naziv partnera'])
                ->rules(['required', 'max:100'])
                ->label('Naziv')
                ->exampleHeader('Naziv partnera'),

            ImportColumn::make('partner_fullname')
                ->requiredMapping()
                ->guess(['Puni naziv', 'Puni naziv partnera'])
                ->rules(['required', 'max:255'])
                ->label('Puni naziv')
                ->exampleHeader('Puni naziv partnera'),

            ImportColumn::make('partner_address')
                ->requiredMapping()
                ->guess(['Adresa', 'Adresa sjedišta'])
                ->rules(['required', 'max:255'])
                ->label('Adresa')
                ->exampleHeader('Adresa sjedišta'),

            ImportColumn::make('partner_city')
                ->requiredMapping()
                ->guess(['Grad', 'Šifra grada'])
                ->rules(['required', 'max:15'])
                ->label('Grad')
                ->exampleHeader('Šifra grada'),

            ImportColumn::make('partner_country')
                ->requiredMapping()
                ->guess(['Država', 'Šifra države'])
                ->rules(['required', 'max:2'])
                ->label('Država')
                ->exampleHeader('Naziv države'),

            ImportColumn::make('partner_region')
                ->requiredMapping()
                ->guess(['Region', 'Šifra regiona'])
                ->rules(['required', 'max:6'])
                ->label('Region')
                ->exampleHeader('Šifra regiona'),

            ImportColumn::make('partner_user')
                ->requiredMapping()
                ->guess(['Referent', 'Šifra referenta'])
                ->rules(['required', 'max:100'])
                ->label('Referent')
                ->exampleHeader('Šifra referenta'),

            ImportColumn::make('partner_jib')
                ->requiredMapping()
                ->guess(['JIB', 'Id broj'])
                ->rules(['required', 'max:20'])
                ->label('JIB')
                ->exampleHeader('JIB'),

            ImportColumn::make('partner_pib')
                ->requiredMapping()
                ->guess(['PIB', 'Poreski broj'])
                ->rules(['required', 'max:20'])
                ->label('PIB')
                ->exampleHeader('PIB'),

            ImportColumn::make('partner_mbs')
                ->requiredMapping()
                ->guess(['MBS', 'Matični broj'])
                ->rules(['required', 'max:20'])
                ->label('MBS')
                ->exampleHeader('MBS'),

            ImportColumn::make('partner_phone')
                ->requiredMapping()
                ->guess(['Telefon', 'Broj telefona'])
                ->rules(['required', 'max:30'])
                ->label('Telefon')
                ->exampleHeader('Telefon'),

            ImportColumn::make('partner_fax')
                ->requiredMapping()
                ->guess(['Fax', 'Broj faxa'])
                ->rules(['required', 'max:30'])
                ->label('Fax')
                ->exampleHeader('Fax'),

            ImportColumn::make('partner_mail')
                ->requiredMapping()
                ->guess(['E-mail', 'E-mail adresa'])
                ->rules(['required', 'max:50'])
                ->label('E-mail')
                ->exampleHeader('E-mail'),

            ImportColumn::make('partner_web')
                ->requiredMapping()
                ->guess(['Web', 'Web adresa'])
                ->rules(['required', 'max:50'])
                ->label('Web')
                ->exampleHeader('Web'),

            ImportColumn::make('partner_contract')
                ->requiredMapping()
                ->guess(['Ugovor', 'Broj ugovora'])
                ->rules(['max:30'])
                ->label('Ugovor')
                ->exampleHeader('Broj ugovora'),

            ImportColumn::make('partner_discount')
                ->requiredMapping()
                ->guess(['Popust', 'Redovni popust'])
                ->rules(['required', 'integer'])
                ->label('Redovni popust')
                ->exampleHeader('Redovni popust'),

            ImportColumn::make('partner_payment_term')
                ->requiredMapping()
                ->guess(['Plaćanje', 'Šifra plaćanja'])
                ->rules(['required', 'max:11'])
                ->label('Plaćanje')
                ->exampleHeader('Šifra plaćanja'),

            ImportColumn::make('partner_incoterm')
                ->requiredMapping()
                ->guess(['Uvjeti isporuke', 'Šifra isporuke'])
                ->rules(['required', 'max:3'])
                ->label('Uvjeti isporuke')
                ->exampleHeader('Šifra isporuke'),

            ImportColumn::make('partner_tax')
                ->requiredMapping()
                ->guess(['Porez', 'Šifra poreza'])
                ->rules(['required', 'max:10'])
                ->label('Porez')
                ->exampleHeader('Porez'),

            ImportColumn::make('partner_limit')
                ->requiredMapping()
                ->guess(['Limit', 'Limit zaduženja'])
                ->rules(['required', 'numeric'])
                ->label('Limit')
                ->exampleHeader('Limit zaduženja'),

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

    public function resolveRecord(): ?Core
    {
        return Core::firstOrNew([
            'partner_index' => $this->data['partner_index'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Uvoz partnera je završen i ' . number_format($import->successful_rows) . ' redova je uvezeno.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' redova nije uvezeno.';
        }

        return $body;
    }
}
