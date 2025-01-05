<?php

namespace App\Filament\Clusters\Settings\FinanceSettings\Resources;

use App\Filament\Clusters\Settings\FinanceSettings;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\FinanceSettings\Resources\TaxResource\Pages;
use App\Models\System\Tax as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\RawJs;

class TaxResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = FinanceSettings::class;

    protected static ?string $modelLabel = 'poreza';
    protected static ?string $pluralModelLabel = 'Porezi';
    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                    ->schema([

                        Forms\Components\TextInput::make('tax_index')
                            ->label('Šifra')
                            ->required()
                            ->maxLength(100),

                        Forms\Components\TextInput::make('tax_name')
                            ->label('Naziv poreza')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('tax_rate')
                            ->label('Stopa')
                            ->required()
                            ->mask(RawJs::make(<<<'JS'
                            $money($input, ',', '', 2)
                        JS)),

                        Forms\Components\TextInput::make('tax_description')
                            ->label('Opis poreza')
                            ->required()
                            ->maxLength(200)
                            ->columnSpan(5),


                    ])
                    ->columns(5)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Porezi')
            ->columns([

                Tables\Columns\TextColumn::make('tax_index')
                    ->label('Šifra'),

                Tables\Columns\TextColumn::make('tax_name')
                    ->label('Naziv poreza')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tax_description')
                    ->label('Opis poreza')
                    ->grow(),

                Tables\Columns\TextColumn::make('tax_rate')
                    ->label('Stopa'),

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

            ])->headerActions([

                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function (array $data): array {

                        $data['ordering'] = nextNumber('ordering', 'system_taxes');
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
            'index' => Pages\ManageTaxes::route('/'),
        ];
    }
}
