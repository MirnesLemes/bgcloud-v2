<?php

namespace App\Filament\Clusters\Settings;

use Filament\Clusters\Cluster;

class SystemSettings extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Postavke';
    protected static ?string $navigationLabel = 'Podešavanje sistema';
    protected static ?int $navigationSort = 1;
}
