<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources;

use App\Filament\Clusters\HomeBases\ProductsBase;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\CategoryResource\Pages;
use App\Filament\Resources\Products\CategoryResource\RelationManagers;
use App\Models\Products\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $cluster = ProductsBase::class;

    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'kategorije';
    protected static ?string $pluralModelLabel = 'Kategorije proizvoda';
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                    ->schema([

                        Forms\Components\TextInput::make('category_index')
                            ->label('Index')
                            ->required()
                            ->maxLength(6)
                            ->minLength(6),

                        Forms\Components\TextInput::make('category_name')
                            ->label('Naziv kategorije')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(3),

                        Forms\Components\Textarea::make('category_description')
                            ->label('Opis kategorije')
                            ->required()
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpan(4),

                        Forms\Components\FileUpload::make('category_thumbnail')
                            ->label('Slika (800x800 px)')
                            ->image()
                            ->preserveFilenames()
                            ->directory('images/category_images')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('800')
                            ->columnSpan(4),

                    ])
                    ->columns(4)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Kategorije proizvoda')
            ->columns([

                Tables\Columns\TextColumn::make('category_index')
                    ->label('Index')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('category_thumbnail')
                    ->label('Slika')
                    ->height(80)
                    ->width(80),

                Tables\Columns\TextColumn::make('category_name')
                    ->label('Naziv/Opis kategorije')
                    ->description(fn($record): string => $record->category_description ?? '')
                    ->searchable(['category_name', 'category_description'])
                    ->wrap()
                    ->weight(FontWeight::Medium),

            ])
            ->defaultSort('ordering', 'asc')
            ->reorderable('ordering')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([

                    Tables\Actions\ViewAction::make()
                        //->disabled(fn()=>!in_array('products_view', Auth::user()->UserRole->products_approvals))                       
                        ->slideOver(),

                    Tables\Actions\EditAction::make()
                        //->disabled(fn()=>!in_array('products_edit', Auth::user()->UserRole->products_approvals))
                        ->mutateFormDataUsing(function (array $data): array {
                            $data['updated_by'] = Auth::user()->user_index;
                            return $data;
                        })
                        ->slideOver(),

                    Tables\Actions\DeleteAction::make()
                    //->disabled(fn()=>!in_array('products_view', Auth::user()->UserRole->products_approvals)),
                ]),
            ])
            ->headerActions([

                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function (array $data): array {

                        $data['ordering'] = nextNumber('ordering', 'product_categories');
                        $data['created_by'] = Auth::user()->user_index;
                        $data['updated_by'] = Auth::user()->user_index;

                        return $data;
                    })
                    ->slideOver(),

                \Filament\Tables\Actions\ImportAction::make()
                    ->importer(\App\Filament\Imports\Products\CategoryImporter::class)
                    ->csvDelimiter(';')
                    ->label('Uvoz kategorija')
                    ->icon('heroicon-o-arrow-up-on-square')
                    ->visible(fn () => Auth::check() && Auth::user()->can('import', Category::class)),

            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
