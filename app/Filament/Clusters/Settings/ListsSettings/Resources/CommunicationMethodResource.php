<?php

namespace App\Filament\Clusters\Settings\ListsSettings\Resources;

use App\Filament\Clusters\Settings\ListsSettings;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\ListsSettings\Resources\CommunicationMethodResource\Pages;
use App\Models\System\CommunicationMethod as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CommunicationMethodResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = ListsSettings::class;

    protected static ?string $modelLabel = 'metoda komunikacije';
    protected static ?string $pluralModelLabel = 'Metodi komunikacije';
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?int $navigationSort = 4;

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
                            ->label('Naziv metoda')
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
            ->heading('Metodi komunikacije')
            ->columns([

                Tables\Columns\TextColumn::make('method_index')
                    ->label('Šifra'),

                Tables\Columns\TextColumn::make('method_name')
                    ->label('Naziv metoda')
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
            'index' => Pages\ManageCommunicationMethods::route('/'),
        ];
    }
}
