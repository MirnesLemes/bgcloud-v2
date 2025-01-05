<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelList extends Model
{
    use HasFactory;

    protected $table = 'system_models';
    protected $primaryKey = 'model_id';
    protected $fillable = [
        'model_namespace',
        'model_description'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
