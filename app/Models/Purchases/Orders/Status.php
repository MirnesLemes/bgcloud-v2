<?php

namespace App\Models\Purchases\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    protected $table = 'purchase_order_statuses';
    protected $primaryKey = 'status_index';
    public $incrementing = false;
    protected $fillable = [
        'status_index',
        'status_name',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public function StatusOrders()
    {
        return $this->hasMany(Core::class, 'order_status', 'status_index');
    }
}
