<?php

namespace App\Filament\Clusters\Settings\ListsSettings\Resources;

use App\Filament\Clusters\Settings\ListsSettings;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\ListsSettings\Resources\RatingResource\Pages;
use App\Models\System\Rating as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RatingResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = ListsSettings::class;

    protected static ?string $modelLabel = 'ocjene';
    protected static ?string $pluralModelLabel = 'Sistem ocjenjivanja';
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                    ->schema([

                        Forms\Components\TextInput::make('rating_index')
                            ->label('Šifra')
                            ->required()
                            ->maxLength(6),

                        Forms\Components\TextInput::make('rating_name')
                            ->label('Opis ocjene')
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
            ->heading('Sistem ocjenjivanja')
            ->columns([

                Tables\Columns\TextColumn::make('rating_index')
                    ->label('Šifra'),

                Tables\Columns\TextColumn::make('rating_name')
                    ->label('Opis ocjene')
                    ->searchable()
                    ->sortable()
                    ->grow(),

            ])
            ->defaultSort('rating_index', 'asc')
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRatings::route('/'),
        ];
    }
}
