<?php

namespace App\Filament\Clusters\Settings\FinanceSettings\Resources;

use App\Filament\Clusters\Settings\FinanceSettings;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\FinanceSettings\Resources\PaymentMethodResource\Pages;
use App\Models\System\PaymentMethod as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = FinanceSettings::class;

    protected static ?string $modelLabel = 'metoda plaćanja';
    protected static ?string $pluralModelLabel = 'Metodi plaćanja';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                    ->schema([

                        Forms\Components\TextInput::make('method_index')
                            ->label('Šifra')
                            ->required()
                            ->maxLength(6),

                        Forms\Components\TextInput::make('method_name')
                            ->label('Naziv metoda plaćanja')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(4),

                    ])
                    ->columns(5)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Metodi plaćanja')
            ->columns([

                Tables\Columns\TextColumn::make('method_index')
                    ->label('Šifra'),

                Tables\Columns\TextColumn::make('method_name')
                    ->label('Naziv metoda plaćanja')
                    ->searchable()
                    ->sortable()
                    ->grow(),

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
            'index' => Pages\ManagePaymentMethods::route('/'),
        ];
    }
}
