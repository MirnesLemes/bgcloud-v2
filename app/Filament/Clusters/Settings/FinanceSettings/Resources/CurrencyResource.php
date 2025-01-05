<?php

namespace App\Filament\Clusters\Settings\FinanceSettings\Resources;

use App\Filament\Clusters\Settings\FinanceSettings;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\FinanceSettings\Resources\CurrencyResource\Pages;
use App\Models\System\Currency as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\RawJs;

class CurrencyResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = FinanceSettings::class;

    protected static ?string $modelLabel = 'valute';
    protected static ?string $pluralModelLabel = 'Valute';
    protected static ?string $navigationIcon = 'heroicon-o-currency-euro';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                    ->schema([

                        Forms\Components\TextInput::make('currency_index')
                            ->label('Šifra')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('currency_name')
                            ->label('Naziv valute')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('currency_rate')
                            ->label('Kurs')
                            ->required()
                            ->mask(RawJs::make('$money($input, ' . ', ', ', 5)')),

                    ])
                    ->columns(5)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Valute')
            ->columns([

                Tables\Columns\TextColumn::make('currency_index')
                    ->label('Šifra')
                    ->alignment('center'),

                Tables\Columns\TextColumn::make('currency_name')
                    ->label('Naziv valute')
                    ->searchable()
                    ->sortable()
                    ->grow(),

                Tables\Columns\TextColumn::make('currency_rate')
                    ->label('Kurs')
                    ->alignment('right'),

                Tables\Columns\ToggleColumn::make('default')
                    ->label('Osnovna valuta')
                    ->alignment('center')

            ])
            ->defaultSort('ordering', 'asc')
            ->reorderable('ordering')
            ->filters([
                //
            ])
            ->headerActions([

                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function (array $data): array {

                        $data['ordering'] = nextNumber('ordering', ResourceModel::getTableName());
                        $data['created_by'] = Auth::user()->user_index;
                        $data['updated_by'] = Auth::user()->user_index;

                        return $data;
                    })
                    ->slideOver(),

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
                        ->slideOver(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                //
            ])
            ->emptyStateActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCurrencies::route('/'),
        ];
    }
}
