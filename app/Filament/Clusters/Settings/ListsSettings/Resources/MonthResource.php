<?php

namespace App\Filament\Clusters\Settings\ListsSettings\Resources;

use App\Filament\Clusters\Settings\ListsSettings;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\ListsSettings\Resources\MonthResource\Pages;
use App\Models\System\Month as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MonthResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = ListsSettings::class;

    protected static ?string $modelLabel = 'mjeseca';
    protected static ?string $pluralModelLabel = 'Lista mjeseci';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                    ->schema([

                        Forms\Components\TextInput::make('month_index')
                            ->label('Šifra')
                            ->required()
                            ->maxLength(6),

                        Forms\Components\TextInput::make('month_name')
                            ->label('Naziv mjeseca')
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
            ->heading('Lista mjeseci')
            ->columns([

                Tables\Columns\TextColumn::make('month_index')
                    ->label('Šifra'),

                Tables\Columns\TextColumn::make('month_name')
                    ->label('Naziv mjeseca')
                    ->searchable()
                    ->sortable()
                    ->grow(),

            ])
            ->defaultSort('month_index', 'asc')
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
            'index' => Pages\ManageMonths::route('/'),
        ];
    }
}
