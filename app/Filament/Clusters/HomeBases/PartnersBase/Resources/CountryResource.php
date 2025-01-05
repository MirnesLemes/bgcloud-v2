<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources;

use App\Filament\Clusters\HomeBases\PartnersBase;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\CountryResource\Pages;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\CountryResource\RelationManagers;
use App\Models\Partners\Country;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;
    protected static ?string $cluster = PartnersBase::class;

    protected static ?int $navigationSort = 7;
    protected static ?string $modelLabel = 'državu';
    protected static ?string $pluralModelLabel = 'Lista država';
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

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

                ])
                ->columns(5)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('country_index')
                    ->label('Index')
                    ->searchable(),

                Tables\Columns\TextColumn::make('country_name')
                    ->label('Naziv države')
                    ->searchable()
                    ->weight(FontWeight::Medium)
                    ->grow(),

            ])
            ->filters([

                Tables\Filters\SelectFilter::make('Autor')
                    ->relationship('CountryAuthor', 'user_name')

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
            'index' => Pages\ManageCountries::route('/'),
        ];
    }    
}
