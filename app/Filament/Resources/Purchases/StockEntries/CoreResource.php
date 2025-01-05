<?php

namespace App\Filament\Resources\Purchases\StockEntries;

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\Purchases\StockEntries\CoreResource\Pages;
use App\Filament\Resources\Purchases\StockEntries\CoreResource\RelationManagers;
use App\Filament\Resources\Purchases\StockEntries\CoreResource\Widgets\Instructions;
use App\Models\Purchases\StockEntries\Core as ResourceModel;
use App\Models\System\Currency;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Carbon\Carbon;
use Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction;

class CoreResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $navigationGroup = 'Nabava';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'kalkulacije';
    protected static ?string $pluralModelLabel = 'Ulazne kalkulacije';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-start-on-rectangle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([

                        Forms\Components\Select::make('entry_type')
                            ->label('Vrsta')
                            ->placeholder('Odaberite vrstu')
                            ->required()
                            ->relationship('StockEntryType', 'type_name', fn(Builder $query) => $query->orderby('ordering'))
                            ->preload()
                            ->searchable()
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('entry_number')
                            ->label('Broj')
                            ->required()
                            ->integer()
                            //->mask('000000')
                            ->default(fn(): string => nextNumber('entry_number', 'stock_entry_core'))
                            ->dehydrated(),

                        Forms\Components\DatePicker::make('entry_date')
                            ->label('Datum')
                            ->required()
                            ->native(false)
                            ->default(Carbon::now())
                            ->displayFormat('d.m.Y'),


                        Forms\Components\Select::make('entry_partner')
                            ->label('Partner')
                            ->placeholder('Odaberite partnera')
                            ->required()
                            ->relationship('StockEntryPartner', 'partner_name', fn(Builder $query) => $query->orderby('partner_index'))
                            ->preload()
                            ->searchable()
                            ->columnSpan(4),

                        Forms\Components\Select::make('entry_warehouse')
                            ->label('Skladište')
                            ->placeholder('Odaberite skladište')
                            ->required()
                            ->relationship('StockEntryWarehouse', 'warehouse_name', fn(Builder $query) => $query->orderby('warehouse_index'))
                            ->preload()
                            ->searchable()
                            ->columnSpan(2),

                        Forms\Components\Select::make('entry_currency')
                            ->label('Valuta fakture')
                            ->placeholder('Odaberite valutu')
                            ->required()
                            ->reactive()
                            ->relationship('StockEntryCurrency', 'currency_name', fn(Builder $query) => $query->orderby('ordering'))
                            ->default(fn() => Currency::where('default', 1)->first()->currency_index)
                            ->afterStateUpdated(function ($state, $set) {
                                $set('entry_currency_rate', Currency::where('currency_index', $state)->first()->currency_rate);
                            })
                            ->preload()
                            ->searchable()
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('entry_currency_rate')
                            ->label('Kurs')
                            ->required()
                            ->numeric()
                            ->default(fn() => Currency::where('default', 1)->first()->currency_rate)
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 6),

                        Forms\Components\Select::make('entry_tax')
                            ->label('Porez')
                            ->placeholder('Odaberite porez')
                            ->required()
                            ->relationship('StockEntryTax', 'tax_name', fn(Builder $query) => $query->orderby('ordering'))
                            ->preload()
                            ->searchable()
                            ->columnSpan(2),

                        Forms\Components\Textarea::make('entry_description')
                            ->label('Primjedbe i napomene')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpan(6),

                    ])
                    ->columns(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->where('entry_year', session('selected_year')))
            ->heading('Ulazne kalkulacije')
            ->columns([
                Tables\Columns\TextColumn::make('entry_index')
                    ->label('Index')
                    ->searchable(),

                Tables\Columns\TextColumn::make('StockEntryMonth.month_name')
                    ->label('Mjesec'),

                Tables\Columns\TextColumn::make('entry_week')
                    ->label('Sedmica')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('entry_date')
                    ->label('Datum')
                    ->date('d.m.Y')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('StockEntryPartner.partner_name')
                    ->label('Dobavljač')
                    ->weight(FontWeight::Medium)
                    ->searchable()
                    ->grow(),

                Tables\Columns\TextColumn::make('StockEntryPartner.PartnerCountry.country_name')
                    ->label('Država')
                    ->searchable(),

                Tables\Columns\TextColumn::make('StockEntryType.type_name')
                    ->label('Vrsta'),

                Tables\Columns\TextColumn::make('entry_sale_amount')
                    ->label('Iznos')
                    ->searchable()
                    ->money('BAM')
                    ->alignment('right'),

                Tables\Columns\IconColumn::make('entry_status')
                    ->label('Robno')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->alignment('center'),
            ])
            ->filters([
                //
            ])
            ->filtersTriggerAction(
                fn(Tables\Actions\Action $action) => $action
                    ->button()
                    ->label('Filtriranje podataka')
                    ->slideOver(),
            )
            ->actions([
                Tables\Actions\ActionGroup::make([
                    MediaAction::make('media-url')
                        ->icon('heroicon-o-document-text')
                        ->modalHeading('Pregled kalkulacije')
                        ->media(function ($record) {

                            $pdfPath = createStockEntryPdf($record->entry_id);
                            return $pdfPath;
                        })
                        ->autoplay()
                        ->label('Pregled PDF datoteke')
                        ->visible(fn () => Auth::check() && Auth::user()->can('pdf', ResourceModel::class)),
                ])
            ])
            ->headerActions([

                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle'),

            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StockEntryItemsRelationManager::class,
            RelationManagers\StockEntryCostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCores::route('/'),
            'view' => Pages\ViewCore::route('/{record}/view'),
            'create' => Pages\CreateCore::route('/create'),
            'edit' => Pages\EditCore::route('/{record}/edit'),
        ];
    }
}
