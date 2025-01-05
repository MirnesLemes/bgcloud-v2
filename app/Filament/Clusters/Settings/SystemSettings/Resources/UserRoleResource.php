<?php

namespace App\Filament\Clusters\Settings\SystemSettings\Resources;

use App\Filament\Clusters\Settings\SystemSettings;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\SystemSettings\Resources\UserRoleResource\Pages;
use App\Models\System\UserRole as ResourceModel;
use App\Filament\Clusters\Settings\SystemSettings\Resources\UserRoleResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserRoleResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = SystemSettings::class;

    protected static ?string $modelLabel = 'korisničke uloge';
    protected static ?string $pluralModelLabel = 'Korisničke uloge';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make()
                ->schema([

                Forms\Components\TextInput::make('role_index')
                    ->label('Šifra')    
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('role_name')
                    ->label('Naziv uloge')    
                    ->required()
                    ->maxLength(100)
                    ->columnSpan(3),

                ])
                ->columns(4)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->heading('Korisničke uloge')
        ->columns([

            Tables\Columns\TextColumn::make('role_index')
                ->label('Šifra'),

            Tables\Columns\TextColumn::make('role_name')
                ->label('Naziv uloge')
                ->searchable()
                ->sortable()
                ->grow(),

        ])
        ->defaultSort('ordering', 'asc')
        ->reorderable('ordering')
        ->filters([

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

    public static function getRelations(): array
    {
        return [
        
            RelationManagers\UserRolePermissionsRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserRoles::route('/'),
            'create' => Pages\CreateUserRole::route('/create'),
            'edit' => Pages\EditUserRole::route('/{record}/edit'),
            'view' => Pages\ViewUserRole::route('/{record}'),
        ];
    }
}
