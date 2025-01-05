<?php

namespace App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources;

use App\Filament\Clusters\DocumentArchives\DocumentsManagement;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources\CoreResource\Pages;
use App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources\CoreResource\RelationManagers;
use App\Models\Documents\Core;
use App\Models\System\UserRole;
use Filament\Support\Enums\FontWeight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Str;
use Hugomyb\FilamentMediaAction\Tables\Actions\MediaAction;

class CoreResource extends Resource
{
    protected static ?string $model = Core::class;
    protected static ?string $cluster = DocumentsManagement::class;

    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'dokumenta';
    protected static ?string $pluralModelLabel = 'Upravljanje dokumentima';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                ->schema([
                   
                    Forms\Components\TextInput::make('document_name')
                        ->label('Naziv dokumenta')    
                        ->required()
                        ->minLength(5)
                        ->maxLength(50)
                        ->columnSpan(4),

                    Forms\Components\DatePicker::make('document_date')
                        ->label('Datum dokumenta')    
                        ->required()
                        ->columnSpan(2)
                        ->native(false)
                        ->default(Carbon::now())
                        ->displayFormat('d.m.Y'),

                    Forms\Components\Select::make('document_category')
                        ->label('Kategorija')
                        ->placeholder('Odaberite kategoriju')
                        ->required()
                        ->relationship('DocumentCategory', 'category_name', fn (Builder $query) => $query->orderby('ordering'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(3),

                    Forms\Components\Select::make('document_partner')
                        ->label('Partner')
                        ->placeholder('Odaberite partnera')
                        ->required()
                        ->relationship('DocumentPartner', 'partner_name', fn (Builder $query) => $query->orderby('partner_name'))
                        ->preload()
                        ->searchable()
                        ->columnSpan(3),

                    Forms\Components\Textarea::make('document_description')
                        ->label('Opis dokumenta')    
                        ->required()
                        ->minLength(5)
                        ->maxLength(200)
                        ->columnSpan(6)
                        ->rows(2),

                    Forms\Components\Select::make('document_users')
                        ->label('Korisnici dokumenta')
                        ->placeholder('Odaberite korisnike')
                        ->options(UserRole::all()->pluck('role_name', 'role_index'))
                        ->multiple()
                        ->required()
                        ->preload()
                        ->searchable()
                        ->columnSpan(6),

                    Forms\Components\TextInput::make('document_full_url')
                        ->label('Url dokumenta')    
                        //->required()
                        //->url()
                        ->minLength(5)
                        ->maxLength(200)
                        ->columnSpan(6),

                    Forms\Components\FileUpload::make('document_url')
                        ->label('Upload datoteke')
                        // ->reactive()
                        // ->afterStateUpdated(function ($set, $state) {
                        //     $set('document_full_url', $state->getRealPath());
                        // })
                        ->getUploadedFileNameForStorageUsing(
                            function (TemporaryUploadedFile $file, $set, $get) {

                                $path = config('app.url'). '/storage/document_uploads/';
                                $filename = uniqid(Str::slug($get('document_name')) . '-');
                                $extension = $file->getClientOriginalExtension();
                                $set('document_full_url', $path . $filename . '.' . $extension);
                                return $filename . '.' . $extension;
                                

                            } 
                        )
                        ->directory('document_uploads')
                        ->acceptedFileTypes(['application/pdf', 'image/*'])
                        ->visibility('public')
                        ->columnSpan(6),

                ])
                ->columns(6)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('DocumentCategory.category_name')
                    ->label('Kategorija'),

                    Tables\Columns\TextColumn::make('document_name')
                    ->label('Naziv/Opis dokumenta')
                    ->description(fn ($record): string => $record->document_description ?? '')
                    ->searchable(['document_name', 'document_description'])
                    ->weight(FontWeight::Medium)
                    ->grow()
                    ->wrap(),

                Tables\Columns\IconColumn::make('document_full_url')
                    ->icon(function ($state) {

                        if (preg_match('/(youtube\.com|youtu\.be)/', $state)) {
                            return 'heroicon-o-play-circle';
                        }

                        $fileExtension = pathinfo($state, PATHINFO_EXTENSION);

                        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'svg', 'webp', 'bmp'])) {
                            return 'heroicon-o-photo';
                        }

                        if ($fileExtension === 'gif') {
                            return 'heroicon-o-gif';
                        }

                        if (in_array($fileExtension, ['mp4', 'webm', 'avi', 'mov'])) {
                            return 'heroicon-o-video-camera';
                        }

                        if (in_array($fileExtension, ['pdf'])) {
                            return 'heroicon-o-document-text';
                        }

                        if (in_array($fileExtension, ['mp3', 'wav', 'ogg', 'aac'])) {
                            return 'heroicon-o-speaker-wave';
                        }

                        return 'heroicon-o-document';
                    })
                    ->action(
                        MediaAction::make('media-url')
                            ->modalHeading(fn($record) => $record->document_name)
                            ->media(fn($record) => $record->document_full_url)
                            ->autoplay()
                            ->label('Pregled datoteke')
                    )
                    ->label('Pregled'),

            ])
            ->filters([
                //
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
            'index' => Pages\ManageCores::route('/'),
        ];
    }
}
