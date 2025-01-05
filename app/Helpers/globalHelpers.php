<?php

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

function createStockEntryPdf($entryId)
{

    $datetime = date_format(Carbon::Now(), 'dmY_His');
    $pdfFileName = 'documents/' . $entryId . '-' . $datetime . '.pdf';

    $entry = \App\Models\Purchases\StockEntries\Core::where('entry_id', $entryId)->first();
    $items = \App\Models\Purchases\StockEntries\Item::where('item_entry', $entryId)->get();
    $costs = \App\Models\Purchases\StockEntries\Cost::where('cost_entry', $entryId)->get();

    $pdf = PDF::loadView('print.stockEntry', compact('entry', 'items', 'costs'))
        ->setPaper('a4', 'landscape')
        ->save(storage_path('app/public/' . $pdfFileName ));

    return Storage::url($pdfFileName);
    
} 

if (! function_exists('nextNumber')) {
    function nextNumber($fieldName, $tableName)
    {

        $maxNumber = DB::scalar("SELECT MAX($fieldName) from $tableName;");
        return $maxNumber+1;
        
    }
}

if (! function_exists('formatDate')) {
    function formatDate($date)
    {

        return date('d.m.Y', strtotime($date));
        
    }
}

if (! function_exists('formatTime')) {
    function formatTime($time)
    {

        return date('H:i', strtotime($time));
        
    }
}

if (! function_exists('importProducts')) {
    function importProducts($tempFileName)
    {

        try {
            
            $tempFilePath = 'storage/' . $tempFileName;
            Excel::import(new App\Imports\ProductsImport, 'storage/' . $tempFileName);
            Notification::make()->title('Uvoz proizvoda uspješan')->success()->send();

        } catch (Exception $ex) {

            Notification::make()
                ->title('Greška pri uvozu proizvoda')
                ->body($ex->getMessage())
                ->danger()
                ->persistent()
                ->send();
            
        }

    }
}

if (! function_exists('importProductVariants')) {
    function importProductVariants($tempFileName)
    {

        try {
            
            $tempFilePath = 'storage/' . $tempFileName;
            Excel::import(new App\Imports\VariantsImport, 'storage/' . $tempFileName);
            Notification::make()->title('Uvoz varijanti uspješan')->success()->send();

        } catch (Exception $ex) {

            Notification::make()
                ->title('Greška pri uvozu varijanti')
                ->body($ex->getMessage())
                ->danger()
                ->persistent()
                ->send();
            
        }

    }
}

if (! function_exists('recalculatePurchaseOrder')) {
    function recalculatePurchaseOrder($orderId)
    {
        try {

            $items = \App\Models\Purchases\Orders\Item::where('item_order', $orderId)->get();
            $order = \App\Models\Purchases\Orders\Core::where('order_id', $orderId)->first(); 

            $order->update([
                
                'order_amount' => $items->sum('item_amount'),
         
            ]);

            Notification::make()->title('Rekalkulacija narudžbe ' . $orderId . ' uspješna')->success()->send();

        } catch (Exception $e) {
            
            Notification::make()
            ->title('Greška pri rekalkulaciji narudžbe ' . $orderId)
            ->danger()
            ->persistent()
            ->body('Opis greške: ' . $e->getMessage())
            ->send();

        }
    }
}

if (! function_exists('converEntryItemPrices')) {
    function converEntryItemPrices($entryId)
    {
        $items = \App\Models\Purchases\StockEntries\Item::where('item_entry', $entryId)->get();
        $entry = \App\Models\Purchases\StockEntries\Core::where('entry_id', $entryId)->first();
        
        try {
            
            foreach ($items as $item) {

                $convertedPrice = round($item->item_invoice_price * $item->item_currency_rate, 6);
                $convertedAmount = round($item->item_quantity * $convertedPrice, 2);

                $item->update([
                
                    'item_invoice_amount' => $item->item_quantity * $item->item_invoice_price,
                    'item_converted_price' => $convertedPrice,
                    'item_converted_amount' => $convertedAmount,
             
                ]);

            }

            Notification::make()->title('Konverzija cijena ulazne kalkulacije ' . $entry->entry_index . ' uspješna')->success()->send();

        } catch (Exception $e) {
            
            Notification::make()
            ->title('Greška pri konverziji cijena ulazne kalkulacije ' . $entry->entry_index)
            ->danger()
            ->persistent()
            ->body('Opis greške: ' . $e->getMessage())
            ->send();

        }
    }
}

if (! function_exists('recalculateEntryItemCosts')) {
    function recalculateEntryItemCosts($entryId)
    {
        $items = \App\Models\Purchases\StockEntries\Item::where('item_entry', $entryId)->get();
        $entry = \App\Models\Purchases\StockEntries\Core::where('entry_id', $entryId)->first();

        try {


            $totalCovertedAmount = $items->sum('item_converted_amount');
            
            foreach ($items as $item) {

                $itemPercentage = $item->item_converted_amount / $totalCovertedAmount;
                $itemCostAmount = round($entry->entry_cost_amount * $itemPercentage, 2);
                $itemCosts = round($itemCostAmount / $item->item_quantity, 6);

                $item->update([
                
                    'item_cost_amount' => $itemCostAmount,
                    'item_costs' => $itemCosts,
             
                ]);

            }

            Notification::make()->title('Rekalkulacija troškova ulazne kalkulacije ' . $entry->entry_index . ' uspješna')->success()->send();

        } catch (Exception $e) {
            
            Notification::make()
            ->title('Greška pri rekalkulaciji troškova ulazne kalkulacije ' . $entry->entry_index)
            ->danger()
            ->persistent()
            ->body('Opis greške: ' . $e->getMessage())
            ->send();

        }
    }
}

if (! function_exists('recalculateEntry')) {
    function recalculateEntry($entryId)
    {
        $items = \App\Models\Purchases\StockEntries\Item::where('item_entry', $entryId)->get();
        $entry = \App\Models\Purchases\StockEntries\Core::where('entry_id', $entryId)->first();

        try {
            
            foreach ($items as $item) {

                $item->update([
                
                    'item_purchase_price' => $item->item_converted_price + $item->item_costs,
                    'item_purchase_amount' => $item->item_converted_amount + $item->item_cost_amount,

                    'item_sale_price' => $item->item_converted_price + $item->item_costs,
                    'item_sale_amount' => $item->item_converted_amount + $item->item_cost_amount,
             
                ]);

            }

            $entry->update([
                
                'entry_invoice_amount' => $items->sum('item_invoice_amount'),
                'entry_converted_amount' => $items->sum('item_converted_amount'),
                'entry_purchase_amount' => $items->sum('item_purchase_amount'),
                'entry_sale_amount' => $items->sum('item_sale_amount'),

         
            ]);


            Notification::make()->title('Rekalkulacija ulazne kalkulacije ' . $entry->entry_index . ' uspješna')->success()->send();

        } catch (Exception $e) {
            
            Notification::make()
            ->title('Greška pri rekalkulaciji ulazne kalkulacije ' . $entry->entry_index)
            ->danger()
            ->persistent()
            ->body('Opis greške: ' . $e->getMessage())
            ->send();

        }
    }
}

if (! function_exists('importPurchaseOrderEntry')) {
    function importPurchaseOrderEntry($orderId, $entryId)
    {
        $orderItems = \App\Models\Purchases\Orders\Item::where('item_order', $orderId)->get();
        $order = \App\Models\Purchases\Orders\Core::where('order_id', $orderId)->first();

        try {
            
            foreach ($orderItems as $orderItem) {

                $entryItem = new \App\Models\Purchases\StockEntries\Item;

                $entryItem->item_entry = $entryId;
                $entryItem->item_product = $orderItem->item_product;
                $entryItem->item_variant = $orderItem->item_variant;
                $entryItem->item_quantity = $orderItem->item_quantity;
                $entryItem->item_invoice_price = $orderItem->item_price;
                $entryItem->item_currency = $order->order_currency;
                $entryItem->item_currency_rate = $order->order_currency_rate;
                $entryItem->created_by = Auth::user()->user_index;
                $entryItem->updated_by = Auth::user()->user_index;

                $entryItem->save();

            }

            converEntryItemPrices($entryId);
            recalculateEntryItemCosts($entryId); 
            recalculateEntry($entryId); 

            Notification::make()->title('Uvoz stavki narudžbe ' . $order->order_index . ' uspješna')->success()->send();

        } catch (Exception $e) {
            
            Notification::make()
            ->title('Greška pri uvozu stavki narudžbe ' . $order->order_index)
            ->danger()
            ->persistent()
            ->body('Opis greške: ' . $e->getMessage())
            ->send();

        }
    }
}

