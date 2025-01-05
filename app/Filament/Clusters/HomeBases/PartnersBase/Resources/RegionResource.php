<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources;

use App\Filament\Clusters\HomeBases\PartnersBase;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\RegionResource\Pages;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\RegionResource\RelationManagers;
use App\Models\Partners\Region;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegionResource extends Resource
{
    protected static ?string $model = Region::class;
    protected static ?string $cluster = PartnersBase::class;

    protected static ?int $navigationSort = 6;
    protected static ?string $modelLabel = 'regiona';
    protected static ?string $pluralModelLabel = 'Komercijalni regioni';
    protected static ?string $navigationIcon = 'heroicon-o-fire';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                ->schema([
                   
                    Forms\Components\TextInput::make('region_index')
                        ->label('Index')    
                        ->required()
                        ->minLength(6)
                        ->maxLength(6),
                
                    Forms\Components\TextInput::make('region_name')
                        ->label('Naziv regiona')    
                        ->required()
                        ->minLength(5)
                        ->maxLength(50)
                        ->columnSpan(2),

                    Forms\Components\Select::make('region_user')
                        ->label('Referent')
                        ->placeholder('Odaberite referenta')
                        ->required()
                        ->relationship('RegionUser', 'user_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),

                ])
                ->columns(5)

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('region_index')
                    ->label('Index')
                    ->searchable(),

                Tables\Columns\TextColumn::make('region_name')
                    ->label('Naziv regiona')
                    ->searchable()
                    ->weight(FontWeight::Medium)
                    ->grow(),

                Tables\Columns\TextColumn::make('RegionUser.user_name')
                    ->label('Referent'),

            ])
            ->defaultSort('ordering', 'asc')
            ->filters([
                
                Tables\Filters\SelectFilter::make('Referent')
                    ->relationship('RegionUser', 'user_name'),                
                
                Tables\Filters\SelectFilter::make('Autor')
                    ->relationship('RegionAuthor', 'user_name')
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
            'index' => Pages\ManageRegions::route('/'),
        ];
    }    
}
