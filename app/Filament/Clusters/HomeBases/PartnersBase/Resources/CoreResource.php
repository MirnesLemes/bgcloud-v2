<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources;

use App\Filament\Clusters\HomeBases\PartnersBase;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\CoreResource\Pages;
use App\Filament\Clusters\HomeBases\PartnersBase\Resources\CoreResource\RelationManagers;
use App\Models\Partners\Core;
use App\Models\Partners\City;
use App\Models\Partners\Region;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Imports\Partners\CoreImporter as PartnersImporter;
use App\Models\User;


class CoreResource extends Resource
{
    protected static ?string $model = Core::class;
    protected static ?string $cluster = PartnersBase::class;

    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'partnera';
    protected static ?string $pluralModelLabel = 'Baza partnera';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Osnovne informacije')
                ->schema([

                    Forms\Components\TextInput::make('partner_index')
                        ->label('Index')    
                        ->required()
                        ->integer()
                        ->default(fn (): string => nextNumber('partner_index', 'partner_core'))
                        ->disabled(fn (): bool => Auth::user()->user_role != 'ADMIN')
                        ->dehydrated()
                        ->autofocus(),
                    
                    Forms\Components\TextInput::make('partner_name')
                        ->label('Naziv partnera')    
                        ->required()
                        ->maxLength(100)
                        ->columnSpan(3),

                    Forms\Components\Select::make('partner_city')
                        ->label('Grad')
                        ->placeholder('Odaberite grad')
                        ->required()
                        ->relationship('PartnerCity', 'city_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->reactive()
                        ->afterStateUpdated( function($state, $set) {

                            $region = City::where('city_index', $state)->first()->city_region; 
                            $set('user_id', Region::where('region_index', $region)->first()->region_user);

                        })
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('partner_fullname')
                        ->label('Puni naziv partnera')    
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(6),

                    Forms\Components\TextInput::make('partner_address')
                        ->label('Adresa sjedišta')    
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(6),

                    Forms\Components\TextInput::make('partner_jib')
                        ->label('JIB partnera')    
                        ->required()
                        ->maxLength(100)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('partner_pib')
                        ->label('PIB partnera')    
                        ->maxLength(100)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('partner_mbs')
                        ->label('MBS partnera')    
                        ->maxLength(100)
                        ->columnSpan(2),

                    Forms\Components\Select::make('partner_incoterm')
                        ->label('Zadani incoterm')
                        ->placeholder('Odaberite incoterm')
                        ->required()
                        ->relationship('PartnerIncoterm', 'incoterm_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),

                    Forms\Components\Select::make('partner_tax')
                        ->label('Zadani porez')
                        ->placeholder('Odaberite porez')
                        ->required()
                        ->relationship('PartnerTax', 'tax_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),

                    Forms\Components\Select::make('partner_user')
                        ->label('Referent')
                        ->placeholder('Odaberite referenta')
                        ->required()
                        ->relationship('PartnerUser', 'user_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(2),

                ])
                ->columns(6),

                Forms\Components\Section::make('Kontakt informacije')
                ->schema([
   
                    Forms\Components\TextInput::make('partner_phone')
                        ->label('Broj telefona')    
                        ->maxLength(100),

                    Forms\Components\TextInput::make('partner_fax')
                        ->label('Broj faxa')    
                        ->maxLength(100),

                    Forms\Components\TextInput::make('partner_mail')
                        ->label('E-mail adresa')  
                        ->email()  
                        ->maxLength(100),

                    Forms\Components\TextInput::make('partner_web')
                        ->label('Web adresa')    
                        ->url()
                        ->maxLength(100),

                ])
                ->columns(2),

                Forms\Components\Section::make('Komercijalni uslovi')
                ->schema([
   
                    Forms\Components\TextInput::make('partner_contract')
                        ->label('Broj ugovora')    
                        ->maxLength(100),

                    Forms\Components\Select::make('partner_payment_term')
                        ->label('Rok plaćanja')
                        ->placeholder('Odaberite rok')
                        ->required()
                        ->relationship('PartnerPaymentTerm', 'term_name', fn (Builder $query) => $query->orderby('term_index'))
                        ->preload()
                        ->searchable(),

                    Forms\Components\TextInput::make('partner_discount')
                        ->label('Redovni rabat')
                        ->currencyMask(thousandSeparator: '.',decimalSeparator: ',',precision: 0)
                        ->default(0),


                    Forms\Components\TextInput::make('partner_limit')
                        ->label('Limit zaduženja')
                        ->currencyMask(thousandSeparator: '.',decimalSeparator: ',',precision: 0)
                        ->default(0),

                    // MoneyInput::make('partner_limit')
                    //     ->currency('BAM')
                    //     ->locale('bs_BA')
                    //     ->decimals(2),
                        

                ])
                ->columns(4),

                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Baza partnera')
            ->columns([

                Tables\Columns\TextColumn::make('partner_index')
                    ->label('Šifra')
                    ->searchable(),

                Tables\Columns\TextColumn::make('partner_name')
                    ->label('Naziv partnera/Referent')
                    ->description(fn ($record): string => $record->PartnerUser->user_name ?? '')
                    ->searchable(['partner_name', 'user_name'])
                    ->weight(FontWeight::Medium)
                    ->grow(),

                Tables\Columns\TextColumn::make('PartnerCity.city_name')
                    ->label('Grad/Region')
                    ->description(fn ($record): string => $record->PartnerRegion->region_name ?? '')
                    ->searchable(['city_name', 'region_name']),
                    
                Tables\Columns\TextColumn::make('partner_phone')
                    ->label('Telefon/E-mail')
                    ->description(fn ($record): string => $record->partner_mail ?? '')
                    ->searchable(['partner_phone', 'partner_mail']), 


            ])
            ->filters([

                Tables\Filters\SelectFilter::make('Država')
                    ->relationship('PartnerCountry', 'country_name'),

                Tables\Filters\SelectFilter::make('Region')
                    ->relationship('PartnerRegion', 'region_name', fn (Builder $query) => $query->orderby('ordering')),

                Tables\Filters\SelectFilter::make('Grad')
                    ->relationship('PartnerCity', 'city_name', fn (Builder $query) => $query->orderby('ordering')),

                Tables\Filters\SelectFilter::make('Referent')
                    ->relationship('PartnerUser', 'user_name', fn (Builder $query) => $query->orderby('ordering')),

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

                Tables\Actions\ImportAction::make()
                    ->importer(PartnersImporter::class)
                    ->csvDelimiter(';')
                    ->label('Uvoz partnera')
                    ->icon('heroicon-o-arrow-up-on-square')
                    ->color('primary')
                    ->visible(fn () => Auth::check() && Auth::user()->can('import', Core::class))
            ])
            ->bulkActions([
                //
            ])
            ->emptyStateActions([
                //
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
        
            RelationManagers\PartnerContactsRelationManager::class,
            RelationManagers\PartnerLocationsRelationManager::class,
            RelationManagers\PartnerCommunicationsRelationManager::class,

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
