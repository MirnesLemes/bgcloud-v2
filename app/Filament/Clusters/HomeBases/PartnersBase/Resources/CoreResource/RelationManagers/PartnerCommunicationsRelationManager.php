<?php

namespace App\Filament\Clusters\HomeBases\PartnersBase\Resources\CoreResource\RelationManagers;

use Illuminate\Support\Facades\Auth;
use app\Models\Partners\Communication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class PartnerCommunicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'PartnerCommunications';
    protected static ?string $recordTitleAttribute = 'communication_method';
    protected static ?string $modelLabel = 'komunikacije';
    protected static ?string $pluralModelLabel = 'Komunikacije sa partnerom';
    protected static ?string $title = 'Komunikacije sa partnerom';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                ->schema([
                       
                    Forms\Components\Select::make('communication_contact')
                        ->label('Kontakt')
                        ->placeholder('Odaberite kontakt')
                        ->required()
                        ->options(function ($livewire) {            
                            $partner = \App\Models\Partners\Core::find($livewire->getOwnerRecord()->partner_index);         
 
                                return $partner->PartnerContacts->pluck('contact_name', 'contact_id');
            
                        })
                        ->preload()
                        ->searchable()
                        ->columnSpan(2), 

                    Forms\Components\Select::make('communication_method')
                        ->label('Način komunikacije')
                        ->placeholder('Odaberite način')
                        ->required()
                        ->relationship('CommunicationMethod', 'method_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(2), 

                    Forms\Components\DatePicker::make('communication_date')
                        ->label('Datum komunikacije')    
                        ->required()
                        ->native(false)
                        ->default(Carbon::now())
                        ->displayFormat('d.m.Y'),
                        
                    Forms\Components\TimePicker::make('communication_starting_time')
                        ->label('Vrijeme početka')  
                        ->seconds(false)  
                        ->native(false)
                        ->required()
                        ->displayFormat('H:i'),

                    Forms\Components\TimePicker::make('communication_ending_time')
                        ->label('Vrijeme završetka') 
                        ->seconds(false)   
                        ->native(false)
                        ->required()
                        ->displayFormat('H:i'),

                    Forms\Components\Select::make('communication_rating')
                        ->label('Ocjena komunikacije')
                        ->placeholder('Odaberite ocjenu')
                        ->required()
                        ->relationship('CommunicationRating', 'rating_name', fn (Builder $query) => $query->orderby('rating_index'))
                        ->preload()
                        ->searchable(), 

                    Forms\Components\Textarea::make('communication_description')
                        ->label('Sažetak komunikacije')    
                        ->required()
                        ->rows(5)
                        ->columnSpan(4),
        
                ])
                ->columns(4)

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Komunikacija sa partnerom')
            ->recordTitleAttribute('communication_method')
            ->columns([
              
            Tables\Columns\TextColumn::make('CommunicationContact.contact_name')
                ->label('Kontakt osoba')
                ->weight(FontWeight::Medium)
                ->searchable(),

            Tables\Columns\TextColumn::make('CommunicationMethod.method_name')
                ->label('Način komunikacije')
                ->searchable(),

            Tables\Columns\TextColumn::make('Time')
                ->label('Vrijeme posjete')
                ->default(fn ($record): string => formatDate($record->communication_date) .', '. formatTime($record->communication_starting_time) .'-'. formatTime($record->communication_ending_time)),

            Tables\Columns\TextColumn::make('communication_description')
                ->label('Sažetak')
                ->wrap()
                ->limit(100)
                ->searchable(),

            Tables\Columns\TextColumn::make('CommunicationAuthor.user_name')
                ->label('Autor'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = Auth::user()->user_index;
                    $data['updated_by'] = Auth::user()->user_index;

                    $max = Communication::max('ordering');
        
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
