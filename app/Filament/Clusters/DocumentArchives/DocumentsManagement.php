<?php

namespace App\Filament\Clusters\DocumentArchives;

use Filament\Clusters\Cluster;

class DocumentsManagement extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Evidencije';
    protected static ?string $navigationLabel = 'Upravljanje dokumentima';
    protected static ?int $navigationSort = 2;
}
