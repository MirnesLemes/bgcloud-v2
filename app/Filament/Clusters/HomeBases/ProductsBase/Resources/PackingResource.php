<?php

namespace App\Filament\Clusters\HomeBases\ProductsBase\Resources;

use App\Filament\Clusters\HomeBases\ProductsBase;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\PackingResource\Pages;
use App\Filament\Clusters\HomeBases\ProductsBase\Resources\PackingResource\RelationManagers;
use App\Models\Products\Packing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PackingResource extends Resource
{
    protected static ?string $model = Packing::class;
    protected static ?string $cluster = ProductsBase::class;

    protected static ?int $navigationSort = 6;
    protected static ?string $modelLabel = 'pakovanja';
    protected static ?string $pluralModelLabel = 'Vrste pakovanja';
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                ->schema([
                   
                    Forms\Components\TextInput::make('packing_index')
                        ->label('Index')    
                        ->required()
                        ->minLength(2)
                        ->maxLength(6),
                
                    Forms\Components\TextInput::make('packing_name')
                        ->label('Naziv pakovanja')    
                        ->required()
                        ->minLength(3)
                        ->maxLength(50)
                        ->columnSpan(4),

                ])
                ->columns(5)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('packing_index')
                    ->label('Index')
                    ->searchable(),

                Tables\Columns\TextColumn::make('packing_name')
                    ->label('Naziv pakovanja')
                    ->searchable()
                    ->weight(FontWeight::Medium)
                    ->grow(),

                Tables\Columns\TextColumn::make('PackingAuthor.user_name')
                    ->label('Autor'),

            ])
            ->defaultSort('ordering', 'asc')
            ->filters([

                Tables\Filters\SelectFilter::make('Autor')
                    ->relationship('PackingAuthor', 'user_name')

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
            'index' => Pages\ManagePackings::route('/'),
        ];
    }    
}
