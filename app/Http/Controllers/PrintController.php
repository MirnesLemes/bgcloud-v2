<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class PrintController extends Controller
{
    public function stockEntry($entryId)
    {

        $entry = \App\Models\Purchases\StockEntries\Core::where('entry_id', $entryId)->first();
        $items = \App\Models\Purchases\StockEntries\Item::where('item_entry', $entryId)->get();

        return view('print.stockEntry', compact('entry', 'items'));

    }
}
