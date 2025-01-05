<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $description = 'Valute';
    protected $table = 'system_currencies';
    protected $primaryKey = 'currency_index';
    public $incrementing = false;
    protected $fillable = [
        'currency_index',
        'currency_name',
        'currency_rate',
        'ordering',
        'default',
        'created_by',
        'updated_by'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function CurrencyAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
