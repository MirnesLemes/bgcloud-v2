<?php

namespace App\Filament\Resources\Purchases\StockEntries\CoreResource\RelationManagers;

use Illuminate\Support\Facades\Auth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use App\Models\Purchases\StockEntries\Core;
use App\Models\Purchases\StockEntries\Cost;
use App\Models\System\Currency;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;

class StockEntryCostsRelationManager extends RelationManager
{
    protected static string $relationship = 'StockEntryCosts';
    protected static ?string $modelLabel = 'troška';
    protected static ?string $pluralModelLabel = 'Troškovi kalkulacije';
    protected static ?string $title = 'Troškovi kalkulacije';

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

                        Forms\Components\Select::make('cost_partner')
                            ->label('Partner')
                            ->placeholder('Odaberite partnera')
                            ->required()
                            ->relationship('EntryCostPartner', 'partner_name', fn(Builder $query) => $query->orderby('partner_index'))
                            ->preload()
                            ->searchable()
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('cost_amount')
                            ->label('Iznos')
                            ->required()
                            ->numeric()
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 2),

                        Forms\Components\Select::make('cost_currency')
                            ->label('Valuta')
                            ->placeholder('Odaberite valutu')
                            ->required()
                            ->reactive()
                            ->relationship('EntryCostCurrency', 'currency_name', fn(Builder $query) => $query->orderby('ordering'))
                            ->default(fn () => Currency::where('default', 1)->first()->currency_index)
                            ->afterStateUpdated(function ($state, $set) {
                                $set('cost_currency_rate', Currency::where('currency_index', $state)->first()->currency_rate);
                            })
                            ->preload()
                            ->searchable()
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('cost_currency_rate')
                            ->label('Iznos')
                            ->required()
                            ->numeric()
                            ->default(fn () => Currency::where('default', 1)->first()->currency_rate)
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 6),

                        Forms\Components\TextInput::make('cost_description')
                            ->label('Opis troška')
                            ->required()
                            ->columnSpan('full'),

                    ])
                    ->columns(5)

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('cost_id')
            ->columns([
                
                Tables\Columns\TextColumn::make('EntryCostPartner.partner_name')
                    ->label('Dobavljač')
                    ->weight(FontWeight::Medium)
                    ->searchable(),

                Tables\Columns\TextColumn::make('cost_description')
                    ->label('Opis troška')
                    ->searchable()
                    ->grow(),

                Tables\Columns\TextColumn::make('cost_amount')
                    ->label('Iznos')
                    ->searchable()
                    ->money(fn ($record) => $record->cost_currency)
                    ->alignment('right'),

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
                    ->after(function ($record, $livewire) {
                        
                        self::ConvertCosts($record->cost_id);
                        self::TotalCost($record->cost_entry);
                        recalculateEntryItemCosts($livewire->ownerRecord->entry_id); //globalhelpers.php
                        recalculateEntry($livewire->ownerRecord->entry_id); //globalhelpers.php
                        //recalculatePurchaseOrder($record->item_order);

                    })
                    ->slideOver(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([

                    Tables\Actions\EditAction::make()
                        ->mutateFormDataUsing(function (array $data): array {
                            $data['updated_by'] = Auth::user()->user_index;
                            return $data;
                        })
                        ->after(function ($record, $livewire) {
                            
                            self::ConvertCosts($record->cost_id);
                            self::TotalCost($record->cost_entry);
                            recalculateEntryItemCosts($livewire->ownerRecord->entry_id); //globalhelpers.php
                            recalculateEntry($livewire->ownerRecord->entry_id); //globalhelpers.php
                            //recalculatePurchaseOrder($record->item_order);
                        })
                        ->slideOver(),
                    Tables\Actions\DeleteAction::make()
                        ->after(function ($livewire) {

                            self::TotalCost($livewire->ownerRecord->entry_id);
                            recalculateEntryItemCosts($livewire->ownerRecord->entry_id); //globalhelpers.php
                            recalculateEntry($livewire->ownerRecord->entry_id); //globalhelpers.php
                            //recalculatePurchaseOrder($record->item_order);
                        }),
                ]),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function ConvertCosts($costId)
    {

        $cost = Cost::where('cost_id', $costId)->first();
        
        $cost->update([
                
            'cost_converted_amount' => round($cost->cost_amount * $cost->cost_currency_rate, 2),
     
        ]);

        return;
    }

    public static function TotalCost($entryId)
    {
        $entry = Core::where('entry_id', $entryId)->first();
        $costs = Cost::where('cost_entry', $entryId)->get();
        
        $entry->update([
                
            'entry_cost_amount' => round($costs->sum('cost_converted_amount'), 2),
     
        ]);

        return;
    }
}
