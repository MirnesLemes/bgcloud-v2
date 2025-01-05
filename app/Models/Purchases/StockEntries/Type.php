<?php

namespace App\Models\Purchases\StockEntries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;

    protected $table = 'stock_entry_types';
    protected $primaryKey = 'type_index';
    public $incrementing = false;
    protected $fillable = [
        'type_index',
        'type_name',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public function TypeStockEntries()
    {
        return $this->hasMany(Core::class, 'entry_type', 'type_index');
    }
}
