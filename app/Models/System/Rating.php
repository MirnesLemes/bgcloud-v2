<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $description = 'Sistem ocjenjivanja';
    protected $table = 'system_ratings';
    protected $primaryKey = 'rating_index';
    public $incrementing = false;
    protected $fillable = [
        'rating_index',
        'rating_name',
        'created_by',
        'updated_by'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
