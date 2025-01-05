<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $description = 'Skladišta kompanije';
    protected $table = 'system_warehouses';
    protected $primaryKey = 'warehouse_index';
    public $incrementing = false;
    protected $fillable = [
        'warehouse_index',
        'warehouse_name',
        'warehouse_description',
        'warehouse_account',
        'warehouse_price_rule',
        'created_by',
        'updated_by'
    ];

    public static function getTableName() 
    {
        return with(new static)->getTable();
    }
}
