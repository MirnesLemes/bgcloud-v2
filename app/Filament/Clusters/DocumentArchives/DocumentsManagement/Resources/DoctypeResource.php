<?php

namespace App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources;

use App\Filament\Clusters\DocumentArchives\DocumentsManagement;
use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\DocumentArchives\DocumentsManagement\Resources\DoctypeResource\Pages;
use App\Models\System\Doctype;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DoctypeResource extends Resource
{
    protected static ?string $model = Doctype::class;
    protected static ?string $cluster = DocumentsManagement::class;

    protected static ?string $modelLabel = 'vrste dokumenta';
    protected static ?string $pluralModelLabel = 'Vrste dokumenata';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Grid::make()
                ->schema([

                    Forms\Components\TextInput::make('type_index')
                        ->label('Šifra')    
                        ->required()
                        ->maxLength(6),

                    Forms\Components\TextInput::make('type_name')
                        ->label('Naziv vrste dokumenta')    
                        ->required()
                        ->maxLength(100)
                        ->columnSpan(4),

                ])
                ->columns(5)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([

            Tables\Columns\TextColumn::make('type_index')
                ->label('Šifra'),

            Tables\Columns\TextColumn::make('type_name')
                ->label('Naziv vrste dokumenta')
                ->searchable()
                ->sortable()
                ->grow(),

        ])
        ->defaultSort('ordering', 'asc')
        ->reorderable('ordering')
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
            'index' => Pages\ManageDoctypes::route('/'),
        ];
    }
}
