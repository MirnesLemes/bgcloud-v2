<?php

namespace App\Filament\Clusters\Settings;

use Filament\Clusters\Cluster;

class FinanceSettings extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Postavke';
    protected static ?string $navigationLabel = 'Podešavanje finansija';
    protected static ?int $navigationSort = 2;
}
