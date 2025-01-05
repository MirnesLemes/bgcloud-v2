<?php

namespace App\Filament\Clusters\Settings\FinanceSettings\Resources;

use App\Filament\Clusters\Settings\FinanceSettings;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\FinanceSettings\Resources\PaymentTermResource\Pages;
use App\Models\System\PaymentTerm as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentTermResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = FinanceSettings::class;

    protected static ?string $modelLabel = 'uvjeta plaćanja';
    protected static ?string $pluralModelLabel = 'Uvjeti plaćanja';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                    ->schema([

                        Forms\Components\TextInput::make('term_index')
                            ->label('Šifra')
                            ->required()
                            ->numeric(),

                        Forms\Components\TextInput::make('term_name')
                            ->label('Naziv uvjeta plaćanja')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('term_description')
                            ->label('Opis uvjeta plaćanja')
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
            ->heading('Uvjeti plaćanja')
            ->columns([

                Tables\Columns\TextColumn::make('term_index')
                    ->label('Šifra'),

                Tables\Columns\TextColumn::make('term_name')
                    ->label('Naziv')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('term_description')
                    ->label('Opis uvjeta plaćanja')
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
            'index' => Pages\ManagePaymentTerms::route('/'),
        ];
    }
}
