<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $description = 'Lista godina';
    protected $table = 'system_years';
    protected $primaryKey = 'year_index';
    public $incrementing = false;
    protected $fillable = [
        'year_index',
        'year_name',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function YearAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
