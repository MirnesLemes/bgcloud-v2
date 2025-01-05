<?php

namespace App\Models\Purchases\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Item extends Model
{
    use HasFactory;

    protected $table = 'purchase_order_items';
    protected $primaryKey = 'item_id';
    protected $fillable = [
        'item_order',
        'item_product',
        'item_variant',
        'item_quantity',
        'item_price',
        'item_amount',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'item_quantity' => 'decimal:2',
        'item_price' => 'decimal:2',
        'item_amount' => 'decimal:2',
    ];

    public function PurchaseItemOrder()
    {
        return $this->belongsTo(Core::class, 'item_order', 'order_id');
    }

    public function PurchaseItemProduct()
    {
        return $this->belongsTo(\App\Models\Products\Core::class, 'item_product', 'product_index');
    }

    public function PurchaseItemVariant()
    {
        return $this->belongsTo(\App\Models\Products\Variant::class, 'item_variant', 'variant_index');
    }
}
