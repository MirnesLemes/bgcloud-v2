<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources;

use App\Filament\Clusters\HomeBases\PartnersBase;
use Illuminate\Support\Facades\Auth;
use App\Models\Partners\City;
use Filament\Support\Enums\FontWeight;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\CityResource\Pages;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\CityResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Support\Facades\Gate;

class CityResource extends Resource
{
    protected static ?string $model = City::class;
    protected static ?string $cluster = PartnersBase::class;

    protected static ?int $navigationSort = 5;
    protected static ?string $modelLabel = 'grada';
    protected static ?string $pluralModelLabel = 'Lista gradova';
    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                ->schema([
                   
                    Forms\Components\TextInput::make('city_index')
                        ->label('Index')    
                        ->required()
                        ->minLength(5)
                        ->maxLength(15),
                
                    Forms\Components\TextInput::make('city_name')
                        ->label('Naziv grada')    
                        ->required()
                        ->minLength(5)
                        ->maxLength(50)
                        ->columnSpan(4),

                    Forms\Components\TextInput::make('city_zip')
                        ->label('Ptt broj')    
                        ->required()
                        ->minLength(3)
                        ->maxLength(13),

                    Forms\Components\Select::make('city_region')
                        ->label('Region')
                        ->placeholder('Odaberite region')
                        ->required()
                        ->relationship('CityRegion', 'region_name')
                        ->preload()
                        ->searchable()
                        ->columnSpan(3)
                        ->createOptionForm([
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

                                    Forms\Components\Hidden::make('created_by')
                                        ->default(Auth::user()->user_index),

                                    Forms\Components\Hidden::make('updated_by')
                                        ->default(Auth::user()->user_index),

                                ])
                                ->columns(5)
            
                            ])
                        ->editOptionForm([
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

                                    Forms\Components\Hidden::make('updated_by')
                                        ->default(Auth::user()->user_index),

                                ])
                                ->columns(5)
            
                            ]),

                    Forms\Components\Select::make('city_country')
                        ->label('Država')
                        ->placeholder('Odaberite državu')
                        ->required()
                        ->relationship('CityCountry', 'country_name')
                        ->preload()
                        ->searchable()
                        ->columnSpan(3)
                        ->createOptionForm([
                            Forms\Components\Grid::make()
                                ->schema([
                                
                                    Forms\Components\TextInput::make('country_index')
                                        ->label('Index')    
                                        ->required()
                                        ->minLength(2)
                                        ->maxLength(2),
                                
                                    Forms\Components\TextInput::make('country_name')
                                        ->label('Naziv države')    
                                        ->required()
                                        ->minLength(5)
                                        ->maxLength(50)
                                        ->columnSpan(4),

                                    Forms\Components\Hidden::make('created_by')
                                        ->default(Auth::user()->user_index),

                                    Forms\Components\Hidden::make('updated_by')
                                        ->default(Auth::user()->user_index),

                                ])
                                ->columns(5)
            
                            ])
                        ->editOptionForm([
                            Forms\Components\Grid::make()
                                ->schema([
                                
                                    Forms\Components\TextInput::make('country_index')
                                        ->label('Index')    
                                        ->required()
                                        ->minLength(2)
                                        ->maxLength(2),
                                
                                    Forms\Components\TextInput::make('country_name')
                                        ->label('Naziv države')    
                                        ->required()
                                        ->minLength(5)
                                        ->maxLength(50)
                                        ->columnSpan(4),

                                    Forms\Components\Hidden::make('created_by')
                                        ->default(Auth::user()->user_index),

                                    Forms\Components\Hidden::make('updated_by')
                                        ->default(Auth::user()->user_index),

                                ])
                                ->columns(5)
            
                            ])

                ])
                ->columns(6)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Lista gradova')
            ->columns([

                Tables\Columns\TextColumn::make('city_index')
                    ->label('Index')
                    ->searchable(),

                Tables\Columns\TextColumn::make('city_name')
                    ->label('Naziv grada')
                    ->searchable()
                    ->weight(FontWeight::Medium)
                    ->grow(),

                Tables\Columns\TextColumn::make('city_zip')
                    ->label('Ptt broj')
                    ->searchable(),

                Tables\Columns\TextColumn::make('CityRegion.region_name')
                    ->label('Region'),

                Tables\Columns\TextColumn::make('CityCountry.country_name')
                    ->label('Država'),

            ])
            ->defaultSort('ordering', 'asc')
            ->filters([

                Tables\Filters\SelectFilter::make('Region')
                    ->relationship('CityRegion', 'region_name'),
                    
                Tables\Filters\SelectFilter::make('Država')
                    ->relationship('CityCountry', 'country_name'),   
                
                Tables\Filters\SelectFilter::make('Autor')
                    ->relationship('CityAuthor', 'user_name')

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
            ->headerActions([

                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['created_by'] = Auth::user()->user_index;
                        $data['updated_by'] = Auth::user()->user_index;

                        $max = City::max('ordering');
            
                        if (! $max) {
                            $data['ordering'] = 1; 
                        } else {
                            $data['ordering'] = $max + 1;
                        }

                        return $data;
                    })
                    ->slideOver(),

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
            'index' => Pages\ManageCities::route('/'),
        ];
    }    
}
