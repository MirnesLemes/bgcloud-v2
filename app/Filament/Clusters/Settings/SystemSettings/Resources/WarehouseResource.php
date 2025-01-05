<?php

namespace App\Filament\Clusters\Settings\SystemSettings\Resources;

use Illuminate\Support\Facades\Auth;
use App\Filament\Clusters\Settings\SystemSettings;
use App\Filament\Clusters\Settings\SystemSettings\Resources\WarehouseResource\Pages;
use App\Models\System\Warehouse as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;

class WarehouseResource extends Resource
{
    protected static ?string $model = ResourceModel::class;
    protected static ?string $cluster = SystemSettings::class;

    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'skladišta';
    protected static ?string $pluralModelLabel = 'Skladišta kompanije';
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([

                        Forms\Components\TextInput::make('warehouse_index')
                            ->label('Šifra')
                            ->required()
                            ->integer(),

                        Forms\Components\TextInput::make('warehouse_name')
                            ->label('Naziv skladišta')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(3),

                        Forms\Components\Select::make('warehouse_price_rule')
                            ->options([
                                'NC' => 'Po nabavnoj cijeni',
                                'PC' => 'Po prodajnoj cijeni bez poreza',
                                'PP' => 'Po prodajnoj cijeni sa porezom',
                            ])
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('warehouse_account')
                            ->label('Konto')
                            ->required()
                            ->integer(),

                        Forms\Components\TextInput::make('warehouse_description')
                            ->label('Opis skladišta')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(5),

                    ])
                    ->columns(6)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Skladišta kompanije')
            ->columns([

                Tables\Columns\TextColumn::make('warehouse_index')
                    ->label('Šifra/Konto')
                    ->description(fn($record): string => $record->warehouse_account ?? ''),

                Tables\Columns\TextColumn::make('warehouse_name')
                    ->label('Naziv/Opis skladišta')
                    ->description(fn($record): string => $record->warehouse_description ?? '')
                    ->searchable(['warehouse_name', 'warehouse_description'])
                    ->wrap()
                    ->weight(FontWeight::Medium),

            ])
            ->defaultSort('warehouse_index', 'asc')
            ->filters([
                //
            ])
            ->headerActions([

                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['created_by'] = Auth::user()->user_index;
                        $data['updated_by'] = Auth::user()->user_index;

                        return $data;
                    })
                    ->slideOver(),

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([

                    Tables\Actions\ViewAction::make()
                        //->disabled(fn()=>!in_array('products_view', Auth::user()->UserRole->products_approvals))                       
                        ->slideOver(),

                    Tables\Actions\EditAction::make()
                        //->disabled(fn()=>!in_array('products_edit', Auth::user()->UserRole->products_approvals))
                        ->mutateFormDataUsing(function (array $data): array {
                            $data['updated_by'] = Auth::user()->user_index;
                            return $data;
                        })
                        ->slideOver(),

                    Tables\Actions\DeleteAction::make()
                    //->disabled(fn()=>!in_array('products_view', Auth::user()->UserRole->products_approvals)),
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
            'index' => Pages\ManageWarehouses::route('/'),
        ];
    }
}
