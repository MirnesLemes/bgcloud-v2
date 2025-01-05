<?php

namespace App\Filament\Resources\Purchases\Orders\CoreResource\RelationManagers;

use Illuminate\Support\Facades\Auth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Actions\Exports\Enums\ExportFormat;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'PurchaseOrderItems';
    protected static ?string $recordTitleAttribute = 'item_variant';
    protected static ?string $modelLabel = 'stavke';
    protected static ?string $pluralModelLabel = 'Stavke narudžbe';
    protected static ?string $title = 'Stavke narudžbe';

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
                            ->afterStateUpdated(function ($livewire, $state, $set) {

                                $variant = \App\Models\Products\Variant::where('variant_code', $state)->first();

                                if (!empty($variant)) {

                                    $set('item_product', $variant->variant_product);
                                    $set('item_variant', $variant->variant_index);
                                    $set('barcode', $variant->variant_barcode);
                                    self::SetVariantDetails($variant->variant_index, $set);
                                }
                            })
                            ->columnSpan(['default' => 2, 'xl' => 2]),

                        Forms\Components\TextInput::make('barcode')
                            ->label('Traženje po barkodu')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function ($livewire, $state, $set) {

                                $variant = \App\Models\Products\Variant::where('variant_barcode', $state)->first();

                                if (!empty($variant)) {

                                    $set('item_product', $variant->variant_product);
                                    $set('item_variant', $variant->variant_index);
                                    $set('code', $variant->variant_code);
                                    self::SetVariantDetails($variant->variant_index, $set);
                                }
                            })
                            ->columnSpan(['default' => 4, 'xl' => 4]),

                        Forms\Components\Select::make('item_product')
                            ->label('Proizvod')
                            ->required()
                            ->placeholder('Odaberite proizvod')
                            ->relationship(
                                'PurchaseItemProduct',
                                'product_name',
                                fn(Builder $query) => $query
                                    ->orderby('ordering')
                            )
                            ->preload()
                            ->searchable()
                            ->reactive()
                            ->columnSpan(['default' => 2, 'xl' => 6]),

                        Forms\Components\Select::make('item_variant')
                            ->label('Varijanta proizvoda')
                            ->required()
                            ->columnSpan(['default' => 2, 'xl' => 6])
                            ->placeholder('Odaberite varijantu')
                            ->options(function (callable $get) {
                                $product = \App\Models\Products\Core::find($get('item_product'));
                                if ($product) {
                                    return $product->ProductVariants->pluck('variant_name', 'variant_index');
                                }
                            })
                            ->reactive()
                            ->searchable()
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
                            ->reactive()
                            ->afterStateUpdated(function ($get, $set, $state) {

                                self::CalculateAmount($state, $get('item_price'), $set);
                                $state = number_format($state, 2, ',', '.');
                            })
                            ->columnSpan(['default' => 1, 'xl' => 2]),

                        Forms\Components\TextInput::make('item_price')
                            ->label('Cijena')
                            ->required()
                            ->numeric()
                            ->suffix(fn($livewire) => $livewire->ownerRecord->order_currency)
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 2)
                            ->afterStateUpdated(function ($get, $set, $state) {

                                self::CalculateAmount($get('item_quantity'), $state, $set);
                                $state = number_format($state, 2, ',', '.');
                            })
                            ->columnSpan(['default' => 1, 'xl' => 2]),

                        Forms\Components\TextInput::make('item_amount')
                            ->label('Iznos stavke')
                            ->numeric()
                            ->required()
                            ->readOnly()
                            //->disabled()
                            ->suffix(fn($livewire) => $livewire->ownerRecord->order_currency)
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 2)
                            ->columnSpan(['default' => 1, 'xl' => 2]),

                    ])
                    ->columns(6)

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item_variant')
            ->columns([

                Tables\Columns\ImageColumn::make('PurchaseItemProduct.product_thumbnail')
                    ->label('')
                    ->size(50)
                    ->square(),

                Tables\Columns\TextColumn::make('PurchaseItemVariant.variant_code')
                    ->label('Šifra')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('PurchaseItemVariant.variant_index')
                    ->label('Index')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('PurchaseItemVariant.variant_name')
                    ->label('Naziv')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium),

                Tables\Columns\TextColumn::make('uom')
                    ->label('Jm')
                    ->searchable()
                    ->getStateUsing(fn($record) => $record->PurchaseItemVariant->variant_packing . ' ' . $record->PurchaseItemVariant->uom_quantity . $record->PurchaseItemVariant->variant_uom)
                    ->sortable(),

                Tables\Columns\TextColumn::make('item_quantity')
                    ->label('Količina')
                    ->searchable()
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->alignment('right'),

                Tables\Columns\TextColumn::make('item_price')
                    ->label('Cijena')
                    ->searchable()
                    ->money(fn($livewire) => $livewire->ownerRecord->order_currency)
                    ->sortable()
                    ->alignment('right'),

                Tables\Columns\TextColumn::make('item_amount')
                    ->label('Iznos')
                    ->searchable()
                    ->money(fn($livewire) => $livewire->ownerRecord->order_currency)
                    ->sortable()
                    ->alignment('right')
                    ->summarize(
                        Sum::make()
                            ->label('Ukupno')
                            ->money(fn($livewire) => $livewire->ownerRecord->order_currency)
                    ),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['created_by'] = Auth::user()->user_index;
                        $data['updated_by'] = Auth::user()->user_index;

                        return $data;
                    })
                    ->after(function ($record) {

                        recalculatePurchaseOrder($record->item_order);
                    })
                    ->slideOver(),

                Tables\Actions\ExportAction::make()
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->label('Izvoz stavki')
                    ->exporter(\App\Filament\Exports\Purchases\OrderItemExporter::class)
                    ->fileName(fn($livewire) => "PurchaseOrder-{$livewire->ownerRecord->order_id}")
                    ->formats([ExportFormat::Xlsx])
                    ->columnMapping(false)
                //->modifyQueryUsing(fn(Builder $query) => $query->where('is_active', true))
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->slideOver(),
                    Tables\Actions\EditAction::make()
                        ->mutateFormDataUsing(function (array $data): array {
                            $data['updated_by'] = Auth::user()->user_index;
                            return $data;
                        })
                        ->after(function ($record) {

                            recalculatePurchaseOrder($record->item_order);
                        })
                        ->slideOver(),
                    Tables\Actions\DeleteAction::make()
                        ->after(function ($record) {

                            recalculatePurchaseOrder($record->item_order);
                        }),
                ]),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function SetVariantDetails($variantIndex, $set)
    {

        $variant = \App\Models\Products\Variant::where('variant_index', $variantIndex)->first();
        //$currency = \App\Models\System\Currency::where('currency_id', $variant->currency_id)->first();    

        $set('item_quantity', number_format(1, 2, ',', '.'));
        $set('item_price', $variant->variant_supprice);
        self::CalculateAmount(1, $variant->variant_supprice, $set);

        return;
    }

    public static function CalculateAmount($varQuantity, $varPrice, $set)
    {

        if (!empty($varQuantity) && !empty($varPrice)) {

            $set('item_amount', $varQuantity * $varPrice);
        }

        return;
    }
}
