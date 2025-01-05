<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources;

use App\Filament\Clusters\HomeBases\ProductsBase;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\BrandResource\Pages;
use App\Models\Products\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;
    protected static ?string $cluster = ProductsBase::class;

    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'brenda';
    protected static ?string $pluralModelLabel = 'Brendovi proizvoda';
    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('brand_index')
                ->label('Index')    
                ->required()
                ->maxLength(6)
                ->minLength(6),
            
            Forms\Components\TextInput::make('brand_name')
                ->label('Naziv branda')    
                ->required()
                ->maxLength(100)
                ->columnSpan(3),
        
            Forms\Components\Textarea::make('brand_description')
                ->label('Opis branda')
                ->required()
                ->rows(3)
                ->maxLength(500)
                ->columnSpan(4),
            
            Forms\Components\FileUpload::make('brand_logo')
                ->label('Logo (Širina 480 x Visina 150 px)')
                ->image()
                ->preserveFilenames()
                ->directory('images/logo_images')
                ->imageResizeTargetWidth('480')
                ->imageResizeTargetHeight('150')
                ->columnSpan(4),   

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('brand_index')
                ->label('Index')
                ->searchable(),

            Tables\Columns\ImageColumn::make('brand_logo')
                ->label('Logo')
                ->height(25)
                ->width(80),

            Tables\Columns\TextColumn::make('brand_name')
                ->label('Naziv brenda')
                ->searchable()
                ->weight(FontWeight::Medium),

            Tables\Columns\TextColumn::make('brand_description')
                ->label('Opis brenda')
                ->searchable()
                ->wrap()
                ->grow(), 

            Tables\Columns\TextColumn::make('BrandAuthor.user_name')
                ->label('Autor'),

            ])
            ->defaultSort('ordering', 'asc')
            ->filters([

                Tables\Filters\SelectFilter::make('Autor')
                    ->relationship('BrandAuthor', 'user_name',), 

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
            'index' => Pages\ManageBrands::route('/'),
        ];
    }    
}
