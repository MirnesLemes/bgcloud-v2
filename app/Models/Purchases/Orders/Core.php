<?php

namespace App\Models\Purchases\Orders;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Core extends BaseModel
{
    use HasFactory;

    protected $description = 'Narudžbe dobavljačima';
    protected $table = 'purchase_order_core';
    protected $primaryKey = 'order_id';
    public $incrementing = false;
    protected $fillable = [
        'order_index',
        'order_type',
        'order_number',
        'order_date',
        'order_deadline',
        'order_partner',
        'order_payment_term',
        'order_incoterm',
        'order_delivery',
        'order_amount',
        'order_currency',
        'order_currency_rate',
        'order_description',
        'order_status',
        'order_doctype',
        'order_year',
        'order_month',
        'order_week',
        'created_by',
        'updated_by'
    ];

    public static function booted() {
        static::creating(function ($model) {
            $model->order_id = Str::uuid();
        });
    }

    public static function getCustomActions(): array
    {
        return [];
    }

    public function PurchaseOrderType()
    {
        return $this->belongsTo(Type::class, 'order_type', 'type_index');
    }

    public function PurchaseOrderPartner()
    {
        return $this->belongsTo(\App\Models\Partners\Core::class, 'order_partner', 'partner_index');
    }

    public function PurchaseOrderPaymentTerm()
    {
        return $this->belongsTo(\App\Models\System\PaymentTerm::class, 'order_payment_term', 'term_index');
    }

    public function PurchaseOrderIncoterm()
    {
        return $this->belongsTo(\App\Models\System\Incoterm::class, 'order_incoterm', 'incoterm_index');
    }

    public function PurchaseOrderCurrency()
    {
        return $this->belongsTo(\App\Models\System\Currency::class, 'order_currency', 'currency_index');
    }

    public function PurchaseOrderMonth()
    {
        return $this->belongsTo(\App\Models\System\Month::class, 'order_month', 'month_index');
    }

    public function PurchaseOrderStatus()
    {
        return $this->belongsTo(Status::class, 'order_status', 'status_index');
    }

    public function PurchaseOrderDocType()
    {
        return $this->belongsTo(\App\Models\System\Doctype::class, 'order_doctype', 'status_index');
    }

    public function PurchaseOrderItems()
    {
        return $this->hasMany(Item::class, 'item_order', 'order_id');
    }
}
