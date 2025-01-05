<?php

namespace App\Filament\Resources\Sales\CatalogResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use App\Models\Products\Variant;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\Action;

class CatalogVariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'CatalogVariants';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('variant_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Varijante proizvoda')
            ->recordTitleAttribute('variant_name')
            ->columns([

                Tables\Columns\TextColumn::make('variant_code')
                    ->label('Šifra')
                    ->searchable(),

                Tables\Columns\TextColumn::make('variant_index')
                    ->label('Index')
                    ->searchable(),

                Tables\Columns\TextColumn::make('variant_name')
                    ->label('Naziv')
                    ->searchable()
                    ->weight(FontWeight::Medium)
                    ->wrap()
                    ->grow(),

                Tables\Columns\TextColumn::make('VariantPacking.packing_name')
                    ->label('Pakovanje')
                    ->getStateUsing(fn($record) => $record->variant_packing . ' ' . $record->uom_quantity . $record->VariantUom->uom_index)
                    ->weight(FontWeight::Medium),

                Tables\Columns\TextColumn::make('variant_price')
                    ->label('Vpc')
                    ->alignment('right'),
            ])
            ->defaultSort('ordering')
            ->filters([

                Tables\Filters\SelectFilter::make('variant_a1_value')
                    ->visible(fn($livewire): bool => $livewire->ownerRecord->product_a1_name != "")
                    ->label(fn($livewire): string => $livewire->ownerRecord->product_a1_name)
                    ->options(function ($livewire) {

                        $values = Variant::where('variant_product', $livewire->ownerRecord->product_index)
                            ->select('variant_a1_value')
                            ->distinct()
                            ->get();

                        if ($values) {
                            return $values->pluck('variant_a1_value', 'variant_a1_value');
                        }
                    }),

                Tables\Filters\SelectFilter::make('variant_a2_value')
                    ->visible(fn($livewire): bool => $livewire->ownerRecord->product_a2_name != "")
                    ->label(fn($livewire): string => $livewire->ownerRecord->product_a2_name)
                    ->options(function ($livewire) {

                        $values = Variant::where('variant_product', $livewire->ownerRecord->product_index)
                            ->select('variant_a2_value')
                            ->distinct()
                            ->get();

                        if ($values) {
                            return $values->pluck('variant_a2_value', 'variant_a2_value');
                        }
                    }),

                Tables\Filters\SelectFilter::make('variant_a3_value')
                    ->visible(fn($livewire): bool => $livewire->ownerRecord->product_a3_name != "")
                    ->label(fn($livewire): string => $livewire->ownerRecord->product_a3_name)
                    ->options(function ($livewire) {

                        $values = Variant::where('variant_product', $livewire->ownerRecord->product_index)
                            ->select('variant_a3_value')
                            ->distinct()
                            ->get();

                        if ($values) {
                            return $values->pluck('variant_a3_value', 'variant_a3_value');
                        }
                    }),

                Tables\Filters\SelectFilter::make('variant_a4_value')
                    ->visible(fn($livewire): bool => $livewire->ownerRecord->product_a4_name != "")
                    ->label(fn($livewire): string => $livewire->ownerRecord->product_a4_name)
                    ->options(function ($livewire) {

                        $values = Variant::where('variant_product', $livewire->ownerRecord->product_index)
                            ->select('variant_a4_value')
                            ->distinct()
                            ->get();

                        if ($values) {
                            return $values->pluck('variant_a4_value', 'variant_a4_value');
                        }
                    }),

                ])
                ->filtersTriggerAction(
                    fn (Action $action) => $action
                        ->button()
                        ->label('Filtriranje podataka')
                        ->slideOver(),
                )
            ->headerActions([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
