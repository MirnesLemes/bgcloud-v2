<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources;

use App\Filament\Clusters\HomeBases\ProductsBase;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\CoreResource\Pages;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\CoreResource\RelationManagers;
use App\Models\Products\Core;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\FontWeight;
use App\Filament\Imports\Products\CoreImporter as ProductsImporter;
use Filament\Tables\Actions\ImportAction;

class CoreResource extends Resource
{
    protected static ?string $model = Core::class;
    protected static ?string $cluster = ProductsBase::class;

    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'proizvoda';
    protected static ?string $pluralModelLabel = 'Baza proizvoda';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            Forms\Components\Section::make('Osnovne informacije')
                ->schema([

                    Forms\Components\TextInput::make('product_index')
                        ->label('Index')    
                        ->required()
                        ->maxLength(30),
                    
                    Forms\Components\TextInput::make('product_name')
                        ->label('Naziv proizvoda')    
                        ->required()
                        ->maxLength(100)
                        ->columnSpan(3),
                
                    Forms\Components\Textarea::make('product_description')
                        ->label('Opis proizvoda')
                        ->required()
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpan(4),

                    Forms\Components\Select::make('product_category')
                        ->label('Kategorija')
                        ->placeholder('Odaberite kategoriju')
                        ->required()
                        ->relationship('ProductCategory', 'category_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),

                    Forms\Components\Select::make('product_brand')
                        ->label('Brend')
                        ->placeholder('Odaberite brend')
                        ->required()
                        ->relationship('ProductBrand', 'brand_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),



                ])
                ->columns(4),

            Forms\Components\Section::make('Detaljne informacije')
                ->schema([

                    Forms\Components\RichEditor::make('product_text')
                        ->label('Tekst o proizvodu'),  
                    
                    Forms\Components\TagsInput::make('product_tags')
                        ->label('Oznake proizvoda')
                        ->placeholder('Unesite oznaku i pritisnite ENTER')
                        ->separator(','),         

            ])
            ->columns(1),

            Forms\Components\Section::make('Mediji')
                ->description('Glavna slika i video za proizvod')
                ->schema([

                    Forms\Components\FileUpload::make('product_thumbnail')
                        ->label('Slika (800x800px)')
                        ->image()
                        ->preserveFilenames()
                        ->directory('images/product_images')
                        ->imageResizeTargetWidth('800')
                        ->imageResizeTargetHeight('800'),   
                    
                    Forms\Components\TextInput::make('product_video')
                        ->label('Youtube link')    
                        ->maxLength(200),         

            ])
            ->columns(1),

            Forms\Components\Section::make('Atributi proizvoda')
                ->description('Atributi se koriste za definiranje i filtriranje varijanti')
                ->schema([

                    Forms\Components\TextInput::make('product_a1_name')
                        ->label('Naziv atributa 1')    
                        ->maxLength(50)
                        ->minLength(6),
                    
                    Forms\Components\TagsInput::make('product_a1_values')
                        ->label('Vrijednosti atributa 1') 
                        ->placeholder('Unesite vrijednost i pritisnite ENTER')
                        ->separator(',') 
                        ->columnSpan(3),   
                        
                    Forms\Components\TextInput::make('product_a2_name')
                        ->label('Naziv atributa 2')    
                        ->maxLength(50)
                        ->minLength(6),
                    
                    Forms\Components\TagsInput::make('product_a2_values')
                        ->label('Vrijednosti atributa 2') 
                        ->placeholder('Unesite vrijednost i pritisnite ENTER')
                        ->separator(',') 
                        ->columnSpan(3), 
                        
                    Forms\Components\TextInput::make('product_a3_name')
                        ->label('Naziv atributa 3')    
                        ->maxLength(50)
                        ->minLength(6),
                    
                    Forms\Components\TagsInput::make('product_a3_values')
                        ->label('Vrijednosti atributa 3') 
                        ->placeholder('Unesite vrijednost i pritisnite ENTER')
                        ->separator(',')  
                        ->columnSpan(3),

                    Forms\Components\TextInput::make('product_a4_name')
                        ->label('Naziv atributa 4')    
                        ->maxLength(50)
                        ->minLength(6),
                    
                    Forms\Components\TagsInput::make('product_a4_values')
                        ->label('Vrijednosti atributa 4') 
                        ->placeholder('Unesite vrijednost i pritisnite ENTER')
                        ->separator(',')  
                        ->columnSpan(3),   

            ])
            ->columns(4)

        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
        ->heading('Baza proizvoda')
        ->columns([

            Tables\Columns\TextColumn::make('product_index')
                ->label('Index')
                ->searchable(),

            Tables\Columns\ImageColumn::make('product_thumbnail')
                ->label('Slika')
                ->size(50)
                ->alignCenter(),

            Tables\Columns\TextColumn::make('product_name')
                ->label('Naziv/Opis proizvoda')
                ->description(fn ($record): string => $record->product_description ?? '')
                ->searchable(['product_name', 'product_description'])
                ->wrap()
                ->weight(FontWeight::Medium),

            // Tables\Columns\TextColumn::make('product_description')
            //     ->label('Opis proizvoda')
            //     ->searchable()
            //     ->wrap(),

            // Tables\Columns\TextColumn::make('ProductCategory.category_name')
            //     ->label('Kategorija'),

            Tables\Columns\ImageColumn::make('ProductBrand.brand_logo')
                ->label('Brend')
                //->description(fn ($record): string => $record->ProductCategory->category_name ?? '')
                ->height(25)
                ->width(80),

        ])
        ->defaultSort('ordering', 'asc')
        ->filters([
            
            Tables\Filters\SelectFilter::make('Kategorija')
            ->relationship('ProductCategory', 'category_name', fn (Builder $query) => $query->orderby('ordering')),

            Tables\Filters\SelectFilter::make('Brend')
            ->relationship('ProductBrand', 'brand_name', fn (Builder $query) => $query->orderby('ordering')),

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
        ->headerActions([

            Tables\Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),

            ImportAction::make()
                ->importer(ProductsImporter::class)
                ->csvDelimiter(';')
                ->label('Uvoz proizvoda')
                ->icon('heroicon-o-arrow-up-on-square')
                ->visible(fn () => Auth::check() && Auth::user()->can('import', Core::class)),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCores::route('/'),
            'view' => Pages\ViewCore::route('/{record}/view'),
            'create' => Pages\CreateCore::route('/create'),
            'edit' => Pages\EditCore::route('/{record}/edit'),
        ];
    }
}
