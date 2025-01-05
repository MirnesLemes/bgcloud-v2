<?php

namespace App\Models\Purchases\StockEntries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cost extends Model
{
    use HasFactory;

    protected $table = 'stock_entry_costs';
    protected $primaryKey = 'cost_id';
    protected $fillable = [
        'cost_entry',
        'cost_partner',
        'cost_description',
        'cost_amount',
        'cost_currency',
        'cost_currency_rate',
        'cost_converted_amount',
        'created_by',
        'updated_by',
    ];

    public function EntryCostEntry()
    {
        return $this->belongsTo(Core::class, 'cost_entry', 'entry_id');
    }

    public function EntryCostPartner()
    {
        return $this->belongsTo(\App\Models\Partners\Core::class, 'cost_partner', 'partner_index');
    }

    public function EntryCostCurrency()
    {
        return $this->belongsTo(\App\Models\System\Currency::class, 'cost_currency', 'currency_index');
    }

}
