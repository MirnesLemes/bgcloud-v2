<?php

namespace App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources;

use App\Filament\Clusters\DocumentArchives\DocumentsManagement;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources\CategoryResource\Pages;
use App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources\CategoryResource\RelationManagers;
use App\Models\Documents\Category;
use Filament\Support\Enums\FontWeight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $cluster = DocumentsManagement::class;

    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'kategorije';
    protected static ?string $pluralModelLabel = 'Kategorije dokumenata';
    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                ->schema([

                    Forms\Components\TextInput::make('category_index')
                        ->label('Šifra kategorije')    
                        ->required()
                        ->minLength(6)
                        ->maxLength(6)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('category_name')
                        ->label('Naziv kategorije')    
                        ->required()
                        ->minLength(5)
                        ->maxLength(50)
                        ->columnSpan(4),

                    Forms\Components\Textarea::make('category_description')
                        ->label('Opis kategorije')    
                        ->required()
                        ->minLength(5)
                        ->maxLength(200)
                        ->columnSpan(6)
                        ->rows(4),

                ])
                ->columns(6)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('category_index')
                    ->label('Šifra kategorije')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category_name')
                    ->label('Naziv/Opis kategorije')
                    ->description(fn ($record): string => $record->category_description ?? '')
                    ->searchable(['category_name', 'category_description'])
                    ->weight(FontWeight::Medium)
                    ->grow()
                    ->wrap(),

            ])
            ->defaultSort('ordering', 'asc')
            ->reorderable('ordering')
            ->filters([
                //
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
            'index' => Pages\ManageCategories::route('/'),
        ];
    }
}
