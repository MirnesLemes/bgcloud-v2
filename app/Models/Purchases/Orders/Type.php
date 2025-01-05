<?php

namespace App\Models\Purchases\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;

    protected $table = 'purchase_order_types';
    protected $primaryKey = 'type_index';
    public $incrementing = false;
    protected $fillable = [
        'type_index',
        'type_name',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public function TypeOrders()
    {
        return $this->hasMany(Core::class, 'order_type', 'type_index');
    }
}
