<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources;

use App\Filament\Clusters\HomeBases\ProductsBase;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\VariantResource\Pages;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\VariantResource\RelationManagers;
use App\Models\Products\Variant;
use App\Models\Products\Category;
use App\Models\Products\Core;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Auth;
use App\Filament\Imports\Products\VariantImporter;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Support\Facades\Log;

class VariantResource extends Resource
{
    protected static ?string $model = Variant::class;
    protected static ?string $cluster = ProductsBase::class;

    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'varijante';
    protected static ?string $pluralModelLabel = 'Varijante proizvoda';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Osnovne informacije')
                ->schema([

                    Forms\Components\TextInput::make('variant_code')
                        ->label('Šifra')    
                        ->required()
                        ->integer()
                        ->default(fn (): string => nextNumber('variant_code', 'product_variants'))
                        ->disabled(fn (): bool => Auth::user()->user_role != 'ADMIN')
                        ->dehydrated()
                        ->autofocus(),

                    Forms\Components\TextInput::make('variant_index')
                        ->label('Index')    
                        ->required()
                        ->maxLength(50)
                        ->minLength(6)
                        ->columnSpan(2),

                    Forms\Components\Select::make('variant_product')
                        ->label('Proizvod')
                        ->placeholder('Odaberite proizvod')
                        ->required()
                        ->relationship('VariantProduct', 'product_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->reactive()
                        ->afterStateUpdated(function ($state, $set) {
                            
                            $product = \App\Models\Products\Core::where('product_index', $state)->first();
                            $set('variant_name', $product->product_name . ' []');
                            $set('variant_a1_index', $product->product_a1_name);
                            $set('variant_a2_index', $product->product_a2_name);
                            $set('variant_a3_index', $product->product_a3_name);
                            $set('variant_a4_index', $product->product_a4_name);

                        })
                        ->searchable()
                        ->columnSpan(3),
                    
                    Forms\Components\TextInput::make('variant_name')
                        ->label('Naziv varijante')    
                        ->required()
                        ->maxLength(100)
                        ->columnSpan(4),

                    Forms\Components\Select::make('variant_origin')
                        ->label('Zemlja porijekla')
                        ->placeholder('Odaberite državu')
                        ->required()
                        ->relationship('VariantCountry', 'country_name')
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),

                    Forms\Components\Select::make('variant_packing')
                        ->label('Način pakovanja')
                        ->placeholder('Odaberite pakovanje')
                        ->required()
                        ->relationship('VariantPacking', 'packing_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),

                    Forms\Components\Select::make('variant_uom')
                        ->label('Jedinica mjere')
                        ->placeholder('Odaberite JM')
                        ->required()
                        ->relationship('VariantUom', 'uom_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('uom_quantity')
                        ->label('Količina JM')    
                        ->required()
                        ->integer(),

                    Forms\Components\TextInput::make('variant_weight')
                        ->label('Težina pakiranja')    
                        ->required()
                        ->mask(RawJs::make(<<<'JS'
                            $money($input, ',', '', 2)
                        JS)),

                    Forms\Components\TextInput::make('variant_barcode')
                        ->label('Barkod')    
                        ->required()
                        ->placeholder('0000000000000')
                        ->minLength(13)
                        ->maxLength(13)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('variant_hscode')
                        ->label('HS kod')    
                        ->placeholder('00000000')
                        ->minLength(8)
                        ->maxLength(8)
                        ->columnSpan(2),

                ])
                ->columns(6),

                Forms\Components\Section::make('Cijene')
                ->schema([
                    
                    Forms\Components\TextInput::make('variant_price')
                        ->label('Veleprodajna cijena')    
                        ->required(),

                    Forms\Components\TextInput::make('variant_taxprice')
                        ->label('Maloprodajna cijena')    
                        ->required(),

                    Forms\Components\TextInput::make('variant_expprice')
                        ->label('Izvozna cijena')    
                        ->required(),

                    Forms\Components\Select::make('variant_expprice_currency')
                        ->label('Valuta IZC')
                        ->placeholder('Odaberite valutu')
                        ->required()
                        ->relationship('VariantExpPriceCurrency', 'currency_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('variant_purprice')
                        ->label('Nabavna cijena')    
                        ->required(),

                    Forms\Components\TextInput::make('variant_supprice')
                        ->label('Dobavljačka cijena')    
                        ->required(),

                    Forms\Components\Select::make('variant_supprice_currency')
                        ->label('Valuta DBC')
                        ->placeholder('Odaberite valutu')
                        ->required()
                        ->relationship('VariantSupPriceCurrency', 'currency_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),

                ])
                ->columns(5),

                Forms\Components\Section::make('Atributi')
                ->schema([

                    Forms\Components\TextInput::make('variant_a1_index')
                        ->label('Atribut 1')
                        ->disabled()
                        ->dehydrated(),

                    Forms\Components\Select::make('variant_a1_value')
                        ->label('Vrijednost atributa 1')
                        ->options(function (callable $get) {    
                            
                            $product = \App\Models\Products\Core::where('product_index', $get('variant_product'))->first();
                            if ($product) {

                                $values = explode(",", $product->product_a1_values);
                                
                                foreach ($values as $value)
                                    $options[$value] = $value;              
                                    return $options;
                                }
                        }
                    ),

                    Forms\Components\TextInput::make('variant_a2_index')
                        ->label('Atribut 2')
                        ->disabled()
                        ->dehydrated(),

                    Forms\Components\Select::make('variant_a2_value')
                        ->label('Vrijednost atributa 2')
                        ->options(function (callable $get) {    
                            
                            $product = \App\Models\Products\Core::where('product_index', $get('variant_product'))->first();
                            if ($product) {

                                $values = explode(",", $product->product_a2_values);
                                
                                foreach ($values as $value)
                                    $options[$value] = $value;              
                                    return $options;
                                }
                        }
                    ),                 

                    Forms\Components\TextInput::make('variant_a3_index')
                        ->label('Atribut 3')
                        ->disabled()
                        ->dehydrated(),

                    Forms\Components\Select::make('variant_a3_value')
                        ->label('Vrijednost atributa 3')
                        ->options(function (callable $get) {    
                            
                            $product = \App\Models\Products\Core::where('product_index', $get('variant_product'))->first();
                            if ($product) {

                                $values = explode(",", $product->product_a3_values);
                                
                                foreach ($values as $value)
                                    $options[$value] = $value;              
                                    return $options;
                                }
                        }
                    ),
                    
                    Forms\Components\TextInput::make('variant_a4_index')
                        ->label('Atribut 1')
                        ->disabled()
                        ->dehydrated(),

                    Forms\Components\Select::make('variant_a4_value')
                        ->label('Vrijednost atributa 4')
                        ->options(function (callable $get) {    
                            
                            $product = \App\Models\Products\Core::where('product_index', $get('variant_product'))->first();
                            if ($product) {

                                $values = explode(",", $product->product_a4_values);
                                
                                foreach ($values as $value)
                                    $options[$value] = $value;              
                                    return $options;
                                }
                        }
                    ),                    

                ])
                ->columns(2) 

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->heading('Varijante proizvoda')
            ->columns([

                Tables\Columns\TextColumn::make('variant_code')
                    ->label('Šifra / Barkod')
                    ->description(fn ($record): string => $record->variant_barcode ?? '0000000000000')
                    ->searchable(['variant_code', 'variant_barcode'])
                    ->weight(FontWeight::Medium),

                Tables\Columns\TextColumn::make('VariantProduct.product_name')
                    ->label('Proizvod / Kategorija')
                    ->description(fn ($record): string => $record->VariantCategory->category_name ?? '')
                    ->searchable()
                    //->searchable(['product_name', 'category_name'])
                    ->weight(FontWeight::Medium),

                Tables\Columns\TextColumn::make('variant_name')
                    ->label('Naziv / Index varijante')
                    ->description(fn ($record): string => $record->variant_index ?? '')
                    ->searchable(['variant_name', 'variant_index'])
                    ->weight(FontWeight::Medium)
                    ->wrap()
                    ->grow(),

                Tables\Columns\TextColumn::make('VariantPacking.packing_name')
                    ->label('Pakovanje')
                    ->description(fn ($record) => $record->uom_quantity . $record->VariantUom->uom_index)
                    ->searchable()
                    //->searchable(['packing_name', 'uom_index'])
                    ->weight(FontWeight::Medium),

                Tables\Columns\TextColumn::make('variant_price')
                    ->label('Vpc / Nc')
                    ->description(fn ($record) => $record->variant_purprice)
                    ->weight(FontWeight::Medium)
                    ->alignment('right'),

            ])
            ->defaultSort('variant_code', 'asc')
            ->filters([
                Tables\Filters\Filter::make('KategorijaProizvoda')
                    ->label('Kaskadni filter')
                    ->form([
                        Forms\Components\Select::make('category_index')
                            ->label('Kategorija')
                            ->placeholder('Odaberite kategoriju')
                            ->relationship('VariantCategory', 'category_name', fn (Builder $query) => $query->orderBy('ordering'))
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                $set('product_index', null);
                            }),
            
                        Forms\Components\Select::make('product_index')
                            ->label('Proizvod')
                            ->placeholder('Odaberite proizvod')
                            ->options(function (callable $get) {
                                $categoryIndex = $get('category_index');
            
                                if ($categoryIndex) {
                                    return Core::where('product_category', $categoryIndex)
                                        ->orderBy('ordering')
                                        ->pluck('product_name', 'product_index');
                                }
                                return [];
                            }),
                    ])
                    ->query(function (Builder $query, array $data) {

                        if (!empty($data['product_index'])) {
                            return $query->where('variant_product', $data['product_index']);
                        } elseif (!empty($data['category_index'])) {
                            return $query->where('variant_category', $data['category_index']);
                        }

                        return $query;
                    })
                    ->indicateUsing(function (array $data) {
                        // Lijepo je prikazati "bedževe" koji kažu što je filtrirano
                        $indicators = [];
            
                        if (!empty($data['category_index'])) {
                            $catName = Category::find($data['category_index'])?->category_name;
                            $indicators['category_index'] = "Kategorija: {$catName}";
                        }
            
                        if (!empty($data['product_index'])) {
                            $prodName = Core::where('product_index', $data['product_index'])->value('product_name');
                            $indicators['product_index'] = "Proizvod: {$prodName}";
                        }
            
                        return $indicators;
                    }),
            ])
            ->filtersTriggerAction(
                fn (Tables\Actions\Action $action) => $action
                    ->button()
                    ->label('Filtriranje podataka')
                    ->slideOver(),
            )
            ->actions([
                    //
            ])
            ->headerActions([

                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle'),

                ImportAction::make()
                    ->importer(VariantImporter::class)
                    ->csvDelimiter(';')
                    ->label('Uvoz varijanti')
                    ->icon('heroicon-o-arrow-up-on-square')
                    ->visible(fn () => Auth::check() && Auth::user()->can('import', Variant::class)),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                //     //Tables\Actions\ForceDeleteBulkAction::make(),
                //     //Tables\Actions\RestoreBulkAction::make(),
                // ]),
            ])
            ->emptyStateActions([
                //
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVariants::route('/'),
            'view' => Pages\ViewVariant::route('/{record}/view'),
            'create' => Pages\CreateVariant::route('/create'),
            'edit' => Pages\EditVariant::route('/{record}/edit'),
        ];
    }    
}
