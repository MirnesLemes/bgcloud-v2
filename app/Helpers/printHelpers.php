<?php

namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;

class PrintHelpers
{
    function createStockEntryPdf($entryId)
    {

        $pdfPath = storage_path('app/public/documents');
        $pdfFileName = $entryId . '.pdf';
    
        if (!file_exists($pdfPath)) {
            mkdir($pdfPath, 0755, true);
        }
    
        $entry = \App\Models\Purchases\StockEntries\Core::where('entry_id', $entryId)->first();
        $items = \App\Models\Purchases\StockEntries\Item::where('item_entry', $entryId)->get();
    
        $pdf = PDF::loadView('print.stockEntry', compact('entry', 'items'))
            ->setPaper('a4', 'landscape')
            ->save("$pdfPath/$pdfFileName");
    
        return "$pdfPath/$pdfFileName";
        
    } 
}
