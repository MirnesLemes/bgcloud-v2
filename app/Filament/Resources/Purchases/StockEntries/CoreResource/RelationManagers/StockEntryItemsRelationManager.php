<?php

namespace App\Filament\Resources\Purchases\StockEntries\CoreResource\RelationManagers;

use Illuminate\Support\Facades\Auth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use App\Models\Purchases\StockEntries\Core;
use App\Models\Purchases\StockEntries\Item;
use App\Models\Purchases\Orders\Core as Orders;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Collection;

class StockEntryItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'StockEntryItems';
    protected static ?string $recordTitleAttribute = 'item_variant';
    protected static ?string $modelLabel = 'stavke';
    protected static ?string $pluralModelLabel = 'Stavke kalkulacije';
    protected static ?string $title = 'Stavke kalkulacije';

    public function isReadOnly(): bool
    {
        return $this->ownerRecord->entry_status;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                    ->schema([

                        Forms\Components\TextInput::make('code')
                            ->label('Traženje po šifri')
                            ->numeric()
                            ->reactive()
                            ->columnSpan(2)
                            ->afterStateUpdated(function ($state, $set) {

                                $variant = \App\Models\Products\Variant::where('variant_code', $state)->first();

                                if (!empty($variant)) {

                                    $set('item_product', $variant->variant_product);
                                    $set('item_variant', $variant->variant_index);
                                    $set('barcode', $variant->variant_barcode);
                                    self::SetVariantDetails($variant->variant_index, $set);
                                }
                            }),


                        Forms\Components\TextInput::make('barcode')
                            ->label('Traženje po barkodu')
                            ->numeric()
                            ->reactive()
                            ->columnSpan(4)
                            ->afterStateUpdated(function ($state, $set) {

                                $variant = \App\Models\Products\Variant::where('variant_barcode', $state)->first();

                                if (!empty($variant)) {

                                    $set('item_product', $variant->variant_product);
                                    $set('item_variant', $variant->variant_index);
                                    $set('code', $variant->variant_code);
                                    self::SetVariantDetails($variant->variant_index, $set);
                                }
                            }),

                        Forms\Components\Select::make('item_product')
                            ->label('Proizvod')
                            ->required()
                            ->placeholder('Odaberite proizvod')
                            ->relationship('EntryItemProduct', 'product_name', fn(Builder $query) => $query->orderby('ordering'))
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->columnSpan('full'),

                        Forms\Components\Select::make('item_variant')
                            ->label('Varijanta proizvoda')
                            ->required()
                            ->placeholder('Odaberite varijantu')
                            ->options(function (callable $get) {
                                $product = \App\Models\Products\Core::find($get('item_product'));
                                if ($product) {
                                    return $product->ProductVariants->pluck('variant_name', 'variant_index');
                                }
                            })
                            ->reactive()
                            ->searchable()
                            ->columnSpan('full')
                            ->afterStateUpdated(function ($livewire, $set, $state) {

                                if (!empty($state)) {

                                    $variant = \App\Models\Products\Variant::where('variant_index', $state)->first();

                                    $set('code', $variant->variant_code);
                                    $set('barcode', $variant->variant_barcode);
                                    self::SetVariantDetails($variant->variant_index, $set);
                                }
                            }),

                        Forms\Components\TextInput::make('item_quantity')
                            ->label('Količina')
                            ->required()
                            ->numeric()
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 2)
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('item_invoice_price')
                            ->label('Fakturna cijena')
                            ->required()
                            ->numeric()
                            ->suffix(fn($livewire) => $livewire->ownerRecord->entry_currency)
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 2)
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('item_currency_rate')
                            ->label('Kurs')
                            ->required()
                            ->numeric()
                            ->disabled()
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 6)
                            ->columnSpan(2),

                    ])
                    ->columns(6)

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item_variant')
            ->columns([

                Tables\Columns\TextColumn::make('EntryItemVariant.variant_code')
                    ->label('Šifra'),

                Tables\Columns\TextColumn::make('EntryItemVariant.variant_name')
                    ->label('Naziv/Index')
                    ->searchable()
                    ->description(fn($record): string => $record->EntryItemVariant->variant_index ?? '')
                    ->sortable()
                    ->weight(FontWeight::Medium),

                Tables\Columns\TextColumn::make('item_quantity')
                    ->label('Količina/Jm')
                    ->searchable()
                    ->numeric(decimalPlaces: 2)
                    ->description(fn($record): string => $record->EntryItemVariant->variant_packing . ' ' . $record->EntryItemVariant->uom_quantity . $record->EntryItemVariant->variant_uom ?? '')
                    ->sortable()
                    ->alignment('right'),

                Tables\Columns\TextColumn::make('item_converted_price')
                    ->label('FC/FV')
                    ->searchable()
                    ->formatStateUsing(fn($state) => Number::format($state, precision: 6, locale: 'bs'))
                    ->description(fn($record) => Number::format($record->item_converted_amount, precision: 2, locale: 'bs') ?? '')
                    ->sortable()
                    ->alignment('right'),

                Tables\Columns\TextColumn::make('item_costs')
                    ->label('TR/TV')
                    ->searchable()
                    ->formatStateUsing(fn($state) => Number::format($state, precision: 6, locale: 'bs'))
                    ->description(fn($record) => Number::format($record->item_cost_amount, precision: 2, locale: 'bs') ?? '')
                    ->sortable()
                    ->alignment('right'),

                Tables\Columns\TextColumn::make('item_purchase_price')
                    ->label('NC/NV')
                    ->searchable()
                    ->formatStateUsing(fn($state) => Number::format($state, precision: 6, locale: 'bs'))
                    ->description(fn($record) => Number::format($record->item_purchase_amount, precision: 2, locale: 'bs') ?? '')
                    ->sortable()
                    ->alignment('right'),

            ])
            ->filters([
                //
            ])
            ->headerActions([

                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function ($livewire, array $data): array {

                        $data['item_currency'] = $livewire->ownerRecord->entry_currency;
                        $data['item_currency_rate'] = $livewire->ownerRecord->entry_currency_rate;
                        $data['created_by'] = Auth::user()->user_index;
                        $data['updated_by'] = Auth::user()->user_index;

                        return $data;
                    })
                    ->after(function ($livewire) {

                        converEntryItemPrices($livewire->ownerRecord->entry_id); // globalhelpers.php
                        recalculateEntryItemCosts($livewire->ownerRecord->entry_id); // globalhelpers.php
                        recalculateEntry($livewire->ownerRecord->entry_id); // globalhelpers.php
                    })
                    ->slideOver(),

                Tables\Actions\Action::make('Uvoz stavki')
                    ->icon('heroicon-o-arrow-up-on-square')
                    ->disabled(fn ($livewire) => $livewire->ownerRecord->entry_status)
                    ->action(function ($livewire, array $data): void {
                        
                        importPurchaseOrderEntry($data['order'], $livewire->ownerRecord->entry_id);
                        
                    })
                    ->form([

                        Forms\Components\Select::make('order')
                            ->label('Narudžba')
                            ->required()
                            ->placeholder('Odaberite narudžbu')
                            ->options(Orders::where('order_status', 'REA')->pluck('order_index', 'order_id')), //00001/2025 - 01.01.2025 - Rawlplug s.a. Poland - 2.194,04 Eur

                    ]),
            ])
            ->actions([

                Tables\Actions\ActionGroup::make([

                    Tables\Actions\EditAction::make()
                        ->mutateFormDataUsing(function (array $data): array {

                            $data['updated_by'] = Auth::user()->user_index;
                            return $data;
                        })
                        ->after(function ($record, $livewire) {

                            converEntryItemPrices($livewire->ownerRecord->entry_id); // globalhelpers.php
                            recalculateEntryItemCosts($livewire->ownerRecord->entry_id); // globalhelpers.php
                            recalculateEntry($livewire->ownerRecord->entry_id); // globalhelpers.php
                        })
                        ->slideOver(),

                    Tables\Actions\DeleteAction::make()
                        ->after(function ($livewire) {

                            recalculateEntryItemCosts($livewire->ownerRecord->entry_id); // globalhelpers.php
                            recalculateEntry($livewire->ownerRecord->entry_id); // globalhelpers.php
                        }),
                ])
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function SetVariantDetails($variantIndex, $set)
    {

        $variant = \App\Models\Products\Variant::where('variant_index', $variantIndex)->first();

        $set('item_quantity', number_format(1, 2, ',', '.'));
        $set('item_invoice_price', $variant->variant_supprice);

        return;
    }


}
