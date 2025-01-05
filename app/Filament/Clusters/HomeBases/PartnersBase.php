<?php

namespace App\Filament\Clusters\HomeBases;

use Filament\Clusters\Cluster;

class PartnersBase extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Šifarnici';
    protected static ?string $navigationLabel = 'Šifarnik partnera';
    protected static ?int $navigationSort = 2;
}
