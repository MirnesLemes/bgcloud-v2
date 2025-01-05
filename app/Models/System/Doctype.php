<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Doctype extends BaseModel
{
    use HasFactory;

    protected $description = 'Vrste dokumenata';
    protected $table = 'system_document_types';
    protected $primaryKey = 'type_index';
    public $incrementing = false;

    protected $fillable = [
        'type_index',
        'type_name',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
