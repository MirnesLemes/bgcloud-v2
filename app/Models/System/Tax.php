<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $description = 'Porezi';
    protected $table = 'system_taxes';
    protected $primaryKey = 'tax_index';
    public $incrementing = false;
    protected $fillable = [
        'tax_index',
        'tax_name',
        'tax_rate',
        'tax_description',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function TaxAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
