<?php

namespace App\Models\Purchases\StockEntries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Item extends Model
{
    use HasFactory;

    protected $table = 'stock_entry_items';
    protected $primaryKey = 'item_id';
    protected $fillable = [
        'item_entry',
        'item_product',
        'item_variant',
        'item_quantity',
        'item_invoice_price',
        'item_currency',
        'item_currency_rate',
        'item_converted_price',
        'item_costs',
        'item_purchase_price',
        'item_tax',
        'item_margin',
        'item_sale_price',
        'item_invoice_amount',
        'item_converted_amount',
        'item_cost_amount',
        'item_purchase_amount',
        'item_tax_amount',
        'item_margin_amount',
        'item_sale_amount',
        'created_by',
        'updated_by',
    ];

    // public function itemQuantity(): Attribute
    // {
    //     return new Attribute(

    //         get: fn($value) => str_replace('.', ',', $value),
    //         set: fn($value) => str_replace(',', '.', $value)

    //     );
    // }

    public function EntryItemEntry()
    {
        return $this->belongsTo(Core::class, 'item_entry', 'entry_id');
    }

    public function EntryItemProduct()
    {
        return $this->belongsTo(\App\Models\Products\Core::class, 'item_product', 'product_index');
    }

    public function EntryItemVariant()
    {
        return $this->belongsTo(\App\Models\Products\Variant::class, 'item_variant', 'variant_index');
    }
}
