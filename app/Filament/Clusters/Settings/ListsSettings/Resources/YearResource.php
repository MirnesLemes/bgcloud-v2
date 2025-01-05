<?php

namespace App\Filament\Clusters\Settings\ListsSettings\Resources;

use App\Filament\Clusters\Settings\ListsSettings;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\ListsSettings\Resources\YearResource\Pages;
use App\Models\System\Year as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YearResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = ListsSettings::class;

    protected static ?string $modelLabel = 'godine';
    protected static ?string $pluralModelLabel = 'Poslovne godine';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                ->schema([

                    Forms\Components\TextInput::make('year_index')
                        ->label(__('Year index'))    
                        ->required()
                        ->maxLength(6),

                    Forms\Components\TextInput::make('year_name')
                        ->label(__('Year description'))    
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
        ->heading('Poslovne godine')
        ->columns([

            Tables\Columns\TextColumn::make('year_index')
            ->label(__('Year index')),

            Tables\Columns\TextColumn::make('year_name')
            ->label(__('Year description'))
                ->searchable()
                ->sortable()
                ->grow(),

        ])
        ->defaultSort('year_index', 'asc')
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
            'index' => Pages\ManageYears::route('/'),
        ];
    }
}
