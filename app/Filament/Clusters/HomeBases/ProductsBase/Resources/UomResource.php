<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources;

use App\Filament\Clusters\HomeBases\ProductsBase;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\UomResource\Pages;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\UomResource\RelationManagers;
use App\Models\Products\Uom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UomResource extends Resource
{ 
    protected static ?string $model = Uom::class;
    protected static ?string $cluster = ProductsBase::class;

    protected static ?int $navigationSort = 5;
    protected static ?string $modelLabel = 'jedinice mjere';
    protected static ?string $pluralModelLabel = 'Jedinice mjere';
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                ->schema([
                   
                    Forms\Components\TextInput::make('uom_index')
                        ->label('Index')    
                        ->required()
                        ->minLength(2)
                        ->maxLength(6),
                
                    Forms\Components\TextInput::make('uom_name')
                        ->label('Naziv jedinice mjere')    
                        ->required()
                        ->minLength(5)
                        ->maxLength(50)
                        ->columnSpan(3),

                ])
                ->columns(4)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('uom_index')
                    ->label('Index')
                    ->searchable(),

                Tables\Columns\TextColumn::make('uom_name')
                    ->label('Naziv jedinice mjere')
                    ->searchable()
                    ->weight(FontWeight::Medium)
                    ->grow(),

                Tables\Columns\TextColumn::make('UomAuthor.user_name')
                    ->label('Autor'),

            ])
            ->defaultSort('ordering', 'asc')
            ->filters([

                Tables\Filters\SelectFilter::make('Autor')
                    ->relationship('UomAuthor', 'user_name')

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
            'index' => Pages\ManageUoms::route('/'),
        ];
    }    
}
