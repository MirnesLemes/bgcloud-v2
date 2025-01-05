<?php

namespace App\Models\Purchases\StockEntries;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Core extends BaseModel
{
    use HasFactory;

    protected $description = 'Ulazne kalkulacije';
    protected $table = 'stock_entry_core';
    protected $primaryKey = 'entry_id';
    public $incrementing = false;
    protected $fillable = [
        'entry_id',
        'entry_index',
        'entry_type',
        'entry_number',
        'entry_date',
        'entry_partner',
        'entry_warehouse',
        'entry_currency',
        'entry_currency_rate',
        'entry_tax',
        'entry_invoice_amount',
        'entry_converted_amount',
        'entry_cost_amount',
        'entry_purchase_amount',
        'entry_tax_amount',
        'entry_margin_amount',
        'entry_sale_amount',
        'entry_description',
        'entry_status',
        'entry_doctype',
        'entry_year',
        'entry_month',
        'entry_week',
        'created_by',
        'updated_by',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->entry_id = Str::uuid();
        });
    }

    public static function getCustomActions(): array
    {
        return [
            'pdf' => 'Kreiranje PDF',
        ];
    }

    public function StockEntryType()
    {
        return $this->belongsTo(Type::class, 'entry_type', 'type_index');
    }

    public function StockEntryPartner()
    {
        return $this->belongsTo(\App\Models\Partners\Core::class, 'entry_partner', 'partner_index');
    }

    public function StockEntryWarehouse()
    {
        return $this->belongsTo(\App\Models\System\Warehouse::class, 'entry_warehouse', 'warehouse_index');
    }

    public function StockEntryCurrency()
    {
        return $this->belongsTo(\App\Models\System\Currency::class, 'entry_currency', 'currency_index');
    }

    public function StockEntryTax()
    {
        return $this->belongsTo(\App\Models\System\Tax::class, 'entry_tax', 'tax_index');
    }

    public function StockEntryMonth()
    {
        return $this->belongsTo(\App\Models\System\Month::class, 'entry_month', 'month_index');
    }

    public function StockEntryDocType()
    {
        return $this->belongsTo(\App\Models\System\Doctype::class, 'entry_doctype', 'type_index');
    }

    public function StockEntryAuthor()
    {
        return $this->belongsTo(\App\Models\System\User::class, 'created_by', 'user_index');
    }

    public function StockEntryItems()
    {
        return $this->hasMany(Item::class, 'item_entry', 'entry_id');
    }

    public function StockEntryCosts()
    {
        return $this->hasMany(Cost::class, 'cost_entry', 'entry_id');
    }

}
