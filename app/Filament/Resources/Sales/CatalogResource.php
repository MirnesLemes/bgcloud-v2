<?php

namespace App\Filament\Resources\Sales;

use App\Filament\Resources\Sales\CatalogResource\Pages;
use App\Filament\Resources\Sales\CatalogResource\RelationManagers;
use App\Models\Sales\Catalog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;

class CatalogResource extends Resource
{
    protected static ?string $model = Catalog::class;
    protected static ?string $navigationGroup = 'Prodaja';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'proizvoda';
    protected static ?string $pluralModelLabel = 'Katalog proizvoda';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([16, 24, 32, 'all'])
            ->contentGrid([
                'md' => 2,
                'xl' => 4,
            ])

            ->columns([
                Stack::make([
                    Tables\Columns\ImageColumn::make('CatalogBrand.brand_logo')
                        ->label('Slika')
                        ->size('50%'),

                    Tables\Columns\ImageColumn::make('product_thumbnail')
                        ->label('Slika')
                        ->size(250),

                    Tables\Columns\TextColumn::make('product_name')
                        ->description(fn(Catalog $record): string => $record->product_description ?? '')
                        ->searchable(['product_name', 'product_description'])
                        ->wrap(),
                ]),
            ])

            ->filters([
                
                Tables\Filters\SelectFilter::make('Kategorija')
                    ->relationship('CatalogCategory', 'category_name', fn (Builder $query) => $query->orderBy('ordering')),

                Tables\Filters\SelectFilter::make('Brand')
                    ->relationship('CatalogBrand', 'brand_name', fn (Builder $query) => $query->orderBy('ordering')),

            ])
            ->filtersTriggerAction(
                fn (Tables\Actions\Action $action) => $action
                    ->button()
                    ->label('Filtriranje podataka')
                    ->slideOver(),
            )
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
        ->defaultSort('ordering');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make()
                    ->schema([
                        Components\Split::make([
                            Components\Grid::make(2)
                                ->schema([
                                    Components\Group::make([
                                        Components\TextEntry::make('product_index')
                                            ->label('Šifra proizvoda')
                                            ->weight(FontWeight::Bold)
                                            ->size(TextEntry\TextEntrySize::Medium),
                                        Components\TextEntry::make('product_name')
                                            ->label('Naziv proizvoda')
                                            ->weight(FontWeight::Bold)
                                            ->size(TextEntry\TextEntrySize::Medium),
                                    ]),
                                    Components\Group::make([
                                        //Components\TextEntry::make('author.name'),
                                        Components\TextEntry::make('CatalogCategory.category_name')
                                            ->label('Kategorija')
                                            ->weight(FontWeight::Bold)
                                            ->size(TextEntry\TextEntrySize::Medium),
                                        Components\TextEntry::make('CatalogBrand.brand_name')
                                            ->label('Brend')
                                            ->weight(FontWeight::Bold)
                                            ->size(TextEntry\TextEntrySize::Medium),
                                        //Components\SpatieTagsEntry::make('tags'),
                                    ]),
                                ]),
                            Components\ImageEntry::make('product_thumbnail')
                                ->hiddenLabel()
                                ->grow(false),
                        ])->from('lg'),
                    ]),
                Components\Section::make('Opis proizvoda')
                    ->schema([
                        Components\TextEntry::make('product_text')
                            ->prose()
                            ->markdown()
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CatalogVariantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCatalogs::route('/'),
            'view' => Pages\ViewCatalog::route('/{record}'),
        ];
    }
}
