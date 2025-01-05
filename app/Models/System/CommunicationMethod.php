<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationMethod extends Model
{
    use HasFactory;

    protected $description = 'Metodi komunikacije';
    protected $table = 'system_communication_methods';
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
}
