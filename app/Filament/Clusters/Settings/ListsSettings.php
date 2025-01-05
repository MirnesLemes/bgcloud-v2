<?php

namespace App\Filament\Clusters\Settings;

use Filament\Clusters\Cluster;

class ListsSettings extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationGroup = 'Postavke';
    protected static ?string $navigationLabel = 'Osnovne liste';
    protected static ?int $navigationSort = 3;
}
