<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources\CoreResource\RelationManagers;

use Illuminate\Support\Facades\Auth;
use app\Models\Partners\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'PartnerContacts';
    protected static ?string $recordTitleAttribute = 'contact_name';
    protected static ?string $modelLabel = 'kontakt';
    protected static ?string $pluralModelLabel = 'Kontakti za partnera';
    protected static ?string $title = 'Kontakti za partnera';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                ->schema([

                    Forms\Components\TextInput::make('contact_name')
                        ->label('Ime kontakta')    
                        ->required()
                        ->maxLength(100),
                    
                    Forms\Components\TextInput::make('contact_workplace')
                        ->label('Radno mjesto')
                        ->maxLength(100)
                        ->columnSpan(2),
        
                    Forms\Components\TextInput::make('contact_phone')
                        ->label('Broj telefona')
                        ->maxLength(50),

                    Forms\Components\TextInput::make('contact_mail')
                        ->label('E-mail adresa')
                        ->email()
                        ->maxLength(50),
        
                    Forms\Components\TextInput::make('contact_mobile')
                        ->label('Broj mobitela')
                        ->maxLength(50),    
        
                ])
                ->columns(3)

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Kontakti za partnera')
            ->recordTitleAttribute('contact_name')
            ->columns([


                Tables\Columns\TextColumn::make('contact_name')
                    ->label('Ime kontakta')
                    ->weight(FontWeight::Bold),
               
                Tables\Columns\TextColumn::make('contact_workplace')
                    ->label('Radno mjesto'), 

                Tables\Columns\TextColumn::make('contact_mobile')
                    ->label('Broj mobitela'), 

                Tables\Columns\TextColumn::make('contact_mail')
                    ->label('E-mail adresa'), 

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = Auth::user()->user_index;
                    $data['updated_by'] = Auth::user()->user_index;

                    $max = Contact::max('ordering');
        
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
