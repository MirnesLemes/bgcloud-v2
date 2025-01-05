<?php

namespace App\Filament\Clusters\Settings\SystemSettings\Resources\UserRoleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use App\Models\System\ModelList;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Helpers\StaticLists;

class UserRolePermissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'UserRolePermissions';
    protected static ?string $modelLabel = 'dozvole';
    protected static ?string $pluralModelLabel = 'Dozvole za ulogu';
    protected static ?string $title = 'Dozvole za ulogu';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('permission_id')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('permission_permissions')
                    ->multiple()
                    ->options(function ($record) {

                        $modelId = $record->permission_model;
                        $modelNamespace = ModelList::where('model_id', $modelId)->first()->model_namespace;
                        return $modelNamespace::getAllActions();

                    })
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('permission_id')
            ->columns([

                Tables\Columns\TextColumn::make('PermissionModel.model_description')
                    ->label('Naziv resursa')
                    ->searchable(),

                Tables\Columns\TextColumn::make('permission_permissions')
                    ->label('Dozvoljene operacije')
                    ->grow()
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    //Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
