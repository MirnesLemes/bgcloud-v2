<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTerm extends Model
{
    use HasFactory;

    protected $description = 'Uvjeti plaćanja';
    protected $table = 'system_payment_terms';
    protected $primaryKey = 'term_index';
    public $incrementing = false;
    protected $fillable = [
        'term_index',
        'term_name',
        'term_description',
        'created_by',
        'updated_by'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function PaymentTermAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
