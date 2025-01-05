<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;

    protected $description = 'Lista mjeseci';
    protected $table = 'system_months';
    protected $primaryKey = 'month_index';
    public $incrementing = false;
    protected $fillable = [
        'month_index',
        'month_name',
        'created_by',
        'updated_by'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function MonthAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
