<?php

namespace App\Filament\Clusters\HomeBases;

use Filament\Clusters\Cluster;

class ProductsBase extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Šifarnici';
    protected static ?string $navigationLabel = 'Šifarnik proizvoda';
    protected static ?int $navigationSort = 1;
}
