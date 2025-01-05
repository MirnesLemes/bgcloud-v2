<?php

namespace App\Filament\Resources\Purchases\Orders; 

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\Purchases\Orders\CoreResource\Pages;
use App\Filament\Resources\Purchases\Orders\CoreResource\RelationManagers;
use App\Models\Purchases\Orders\Core as ResourceModel;
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

class CoreResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $navigationGroup = 'Nabava';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'narudžbe';
    protected static ?string $pluralModelLabel = 'Narudžbe dobavljačima';
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make()
                    ->schema([

                        Forms\Components\Select::make('order_type')
                            ->label('Vrsta')
                            ->placeholder('Odaberite vrstu')
                            ->required()
                            ->relationship('PurchaseOrderType', 'type_name', fn(Builder $query) => $query->orderby('ordering'))
                            ->preload()
                            ->searchable()
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('order_number')
                            ->label('Broj')
                            ->required()
                            ->integer()
                            //->mask('000000')
                            ->default(fn(): string => nextNumber('order_number', 'purchase_order_core'))
                            ->dehydrated(),

                        Forms\Components\DatePicker::make('order_date')
                            ->label('Datum')
                            ->required()
                            ->native(false)
                            ->default(Carbon::now())
                            ->displayFormat('d.m.Y'),

                        Forms\Components\DatePicker::make('order_deadline')
                            ->label('Rok')
                            ->required()
                            ->native(false)
                            ->default(Carbon::now())
                            ->displayFormat('d.m.Y'),

                        Forms\Components\Select::make('order_partner')
                            ->label('Partner')
                            ->placeholder('Odaberite partnera')
                            ->required()
                            ->relationship('PurchaseOrderPartner', 'partner_name', fn(Builder $query) => $query->orderby('partner_index'))
                            ->preload()
                            ->searchable()
                            ->columnSpan(4),

                        Forms\Components\Select::make('order_payment_term')
                            ->label('Način plaćanja')
                            ->placeholder('Odaberite način plaćanja')
                            ->required()
                            ->relationship('PurchaseOrderPaymentTerm', 'term_name', fn(Builder $query) => $query->orderby('ordering'))
                            ->preload()
                            ->searchable()
                            ->columnSpan(2),

                        Forms\Components\Select::make('order_currency')
                            ->label('Valuta')
                            ->placeholder('Odaberite valutu')
                            ->required()
                            ->reactive()
                            ->relationship('PurchaseOrderCurrency', 'currency_name', fn(Builder $query) => $query->orderby('ordering'))
                            ->default(fn () => Currency::where('default', 1)->first()->currency_index)
                            ->afterStateUpdated(function ($state, $set) {
                                $set('order_currency_rate', Currency::where('currency_index', $state)->first()->currency_rate);
                            })
                            ->preload()
                            ->searchable()
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('order_currency_rate')
                            ->label('Kurs')
                            ->required()
                            ->numeric()
                            ->default(fn () => Currency::where('default', 1)->first()->currency_rate)
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 6),

                        Forms\Components\Select::make('order_incoterm')
                            ->label('Incoterm')
                            ->placeholder('Odaberite incoterm')
                            ->required()
                            ->relationship('PurchaseOrderIncoterm', 'incoterm_name', fn(Builder $query) => $query->orderby('ordering'))
                            ->preload()
                            ->searchable()
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('order_delivery')
                            ->label('Detalji isporuke')
                            ->required()
                            ->columnSpan(6),

                        Forms\Components\Textarea::make('order_description')
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
            ->modifyQueryUsing(fn (Builder $query) => $query->where('order_year', session('selected_year')))
            ->heading('Narudžbe dobavljačima')
            ->columns([

                Tables\Columns\TextColumn::make('order_index')
                    ->label('Index')
                    ->searchable(),

                Tables\Columns\TextColumn::make('PurchaseOrderMonth.month_name')
                    ->label('Mjesec'),

                Tables\Columns\TextColumn::make('order_week')
                    ->label('Sedmica')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('order_date')
                    ->label('Datum')
                    ->date('d.m.Y')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('order_deadline')
                    ->label('Rok')
                    ->date('d.m.Y')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('PurchaseOrderPartner.partner_name')
                    ->label('Dobavljač')
                    ->weight(FontWeight::Medium)
                    ->searchable()
                    ->grow(),

                Tables\Columns\TextColumn::make('PurchaseOrderPartner.PartnerCountry.country_name')
                    ->label('Država')
                    ->searchable(),

                Tables\Columns\TextColumn::make('PurchaseOrderType.type_name')
                    ->label('Vrsta'),

                Tables\Columns\TextColumn::make('order_amount')
                    ->label('Iznos')
                    ->searchable()
                    ->money(fn($record) => $record->order_currency)
                    ->alignment('right'),

                Tables\Columns\TextColumn::make('PurchaseOrderStatus.status_name')
                    ->label('Status'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Vrsta')
                    ->relationship('PurchaseOrderType', 'type_name', fn(Builder $query) => $query->orderBy('ordering')),

                Tables\Filters\SelectFilter::make('Mjesec')
                    ->relationship('PurchaseOrderMonth', 'month_name', fn(Builder $query) => $query->orderBy('month_index')),

                Tables\Filters\SelectFilter::make('Status')
                    ->relationship('PurchaseOrderStatus', 'status_name', fn(Builder $query) => $query->orderBy('ordering')),
            ])
            ->filtersTriggerAction(
                fn(Tables\Actions\Action $action) => $action
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

            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderItemsRelationManager::class,
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
