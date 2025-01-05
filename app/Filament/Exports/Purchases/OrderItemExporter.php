<?php

namespace App\Filament\Exports\Purchases;

use App\Models\Purchases\Orders\Item;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class OrderItemExporter extends Exporter
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        return [

            ExportColumn::make('item_product')
                ->label('Index proizvoda'),

            ExportColumn::make('item_variant')
                ->label('Index varijante'),

            ExportColumn::make('PurchaseItemVariant.variant_name')
                ->label('Naziv varijante'),

            ExportColumn::make('PurchaseItemVariant.variant_name')
                ->label('Naziv varijante'),

            ExportColumn::make('uom')
                ->getStateUsing(fn ($record)=> $record->PurchaseItemVariant->variant_packing . ' ' . $record->PurchaseItemVariant->uom_quantity . $record->PurchaseItemVariant->variant_uom)
                ->label('Jm'),

            ExportColumn::make('item_quantity')
                ->label('Količina')
                ->formatStateUsing(fn ($state) => number_format($state,2,",",".")),

            ExportColumn::make('item_price')
                ->label('Cijena')
                ->formatStateUsing(fn ($state) => number_format($state,2,",",".")),

            ExportColumn::make('item_amount')
                ->label('Iznos')
                ->formatStateUsing(fn ($state) => number_format($state,2,",",".")),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Izvoz stavki je završen i ' . number_format($export->successful_rows) . ' stavki je izvezeno.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' nije izvezeno.';
        }

        return $body;
    }
}
