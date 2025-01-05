<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources\CoreResource\RelationManagers;

use Illuminate\Support\Facades\Auth;
use app\Models\Partners\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerLocationsRelationManager extends RelationManager
{
    protected static string $relationship = 'PartnerLocations';
    protected static ?string $recordTitleAttribute = 'location_name';
    protected static ?string $modelLabel = 'lokacije';
    protected static ?string $pluralModelLabel = 'Lokacije isporuke';
    protected static ?string $title = 'Lokacije za partnera';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                ->schema([

                    Forms\Components\TextInput::make('location_name')
                        ->label('Naziv lokacije')    
                        ->required()
                        ->maxLength(100),

                    Forms\Components\TextInput::make('location_jib')
                        ->label('JIB lokacije') 
                        ->maxLength(100),

                    Forms\Components\TextInput::make('location_address')
                        ->label('Adresa lokacije')
                        ->maxLength(100)
                        ->columnSpan(2),

                    Forms\Components\Select::make('location_city')
                        ->label('Grad')
                        ->placeholder('Odaberite grad')
                        ->required()
                        ->relationship('LocationCity', 'city_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable(),     
                    
                    Forms\Components\TextInput::make('location_geolocation')
                        ->label('Geolokacija')
                        ->maxLength(100),   
        
                ])
                ->columns(2)

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Lokacije partnera')
            ->recordTitleAttribute('location_name')
            ->columns([


                Tables\Columns\TextColumn::make('location_name')
                    ->label('Naziv lokacije')
                    ->weight(FontWeight::Bold)
                    ->searchable(),

                Tables\Columns\TextColumn::make('location_address')
                    ->label('Adresa')
                    ->searchable(),
               
                Tables\Columns\TextColumn::make('LocationCity.city_name')
                    ->label('Grad')
                    ->searchable(),

                Tables\Columns\TextColumn::make('location_geolocation')
                    ->label('Geolokacija')
                    ->copyable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = Auth::user()->user_index;
                    $data['updated_by'] = Auth::user()->user_index;

                    $max = Location::max('ordering');
        
                    if (! $max) {
                        $data['ordering'] = 1; 
                    } else {
                        $data['ordering'] = $max + 1;
                    }

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

}
