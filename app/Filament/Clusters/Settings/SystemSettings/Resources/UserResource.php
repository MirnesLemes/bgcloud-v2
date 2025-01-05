<?php

namespace App\Filament\Clusters\Settings\SystemSettings\Resources;

use App\Filament\Clusters\Settings\SystemSettings;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\SystemSettings\Resources\UserResource\Pages;
use App\Models\System\User as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Password;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = SystemSettings::class;

    protected static ?string $modelLabel = 'korisnika';
    protected static ?string $pluralModelLabel = 'Korisnici';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Split::make([

                    Forms\Components\Grid::make()
                        ->schema([

                            Forms\Components\TextInput::make('user_index')
                                ->label('Šifra korisnika')
                                ->required()
                                ->maxLength(100),

                            Forms\Components\TextInput::make('user_name')
                                ->label('Ime korisnika')
                                ->required()
                                ->maxLength(100),

                            Forms\Components\TextInput::make('user_email')
                                ->label('E-mail')
                                ->required()
                                ->maxLength(100)
                                ->email(),

                            Forms\Components\Select::make('user_role')
                                ->label('Nivo ovlaštenja')
                                ->placeholder('Odaberite nivo')
                                ->required()
                                ->relationship('UserRole', 'role_name', fn(Builder $query) => $query->orderby('ordering'))
                                ->preload()
                                ->searchable(),

                            Forms\Components\TextInput::make('user_password')
                                ->label('Lozinka')
                                ->placeholder('Ostavite prazno za zadržavanje postojeće lozinke')
                                ->maxLength(100)
                                ->password()
                                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                ->dehydrated(fn($state) => filled($state)),

                        ])
                        ->columns(1),

                    Forms\Components\Grid::make()
                        ->schema([

                            Forms\Components\FileUpload::make('avatar_url')
                                ->label('Fotografija')
                                ->directory('assets/images')
                                ->image(),

                        ])
                        ->columns(1),

                ])
                    ->columnSpan('full')
                    ->from('md'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Korisnici sistema')
            ->columns([

                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->circular()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('user_index')
                    ->label('Šifra'),

                Tables\Columns\TextColumn::make('user_name')
                    ->label('Ime korisnika')
                    ->searchable()
                    ->sortable()
                    ->grow(),

                Tables\Columns\TextColumn::make('user_email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable()
                    ->grow(),

                Tables\Columns\TextColumn::make('UserRole.role_name')
                    ->label('Nivo ovlaštenja')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('approved')
                    ->label('Odobrenje'),

            ])
            ->defaultSort('ordering', 'asc')
            ->reorderable('ordering')
            ->filters([

                Tables\Filters\SelectFilter::make('user_role')
                    ->relationship('UserRole', 'role_name')
                    ->label('Nivo ovlaštenja'),

                Tables\Filters\TernaryFilter::make('approved')
                    ->label('Odobrenje')
                    ->nullable()

            ])
            ->headerActions([

                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['ordering'] = nextNumber('ordering', ResourceModel::getTableName());
                        $data['created_by'] = Auth::user()->user_index;
                        $data['updated_by'] = Auth::user()->user_index;
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
