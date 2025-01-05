<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $description = 'Metodi plaćanja';
    protected $table = 'system_payment_methods';
    protected $primaryKey = 'method_index';
    public $incrementing = false;
    protected $fillable = [
        'method_index',
        'method_name',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function PaymentMethodAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
