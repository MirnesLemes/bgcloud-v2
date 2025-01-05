<?php

namespace App\Filament\Clusters\Settings\FinanceSettings\Resources;

use App\Filament\Clusters\Settings\FinanceSettings;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\FinanceSettings\Resources\IncotermResource\Pages;
use App\Models\System\Incoterm as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IncotermResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = FinanceSettings::class;

    protected static ?string $modelLabel = 'uvjeta isporuke';
    protected static ?string $pluralModelLabel = 'Uvjeti isporuke';
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                    ->schema([

                        Forms\Components\TextInput::make('incoterm_index')
                            ->label('Šifra')
                            ->required()
                            ->maxLength(6),

                        Forms\Components\TextInput::make('incoterm_name')
                            ->label('Naziv uvjeta po Incoterms')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('incoterm_description')
                            ->label('Opis uvjeta')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(5),

                    ])
                    ->columns(5)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Uvjeti isporuke')
            ->columns([

                Tables\Columns\TextColumn::make('incoterm_index')
                    ->label('Šifra'),

                Tables\Columns\TextColumn::make('incoterm_name')
                    ->label('Naziv uvjeta')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('incoterm_description')
                    ->label('Opis uvjeta isporuke')
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
            'index' => Pages\ManageIncoterms::route('/'),
        ];
    }
}
