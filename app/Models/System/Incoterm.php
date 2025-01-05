<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incoterm extends Model
{
    use HasFactory;

    protected $description = 'Uvjeti isporuke';
    protected $table = 'system_incoterms';
    protected $primaryKey = 'incoterm_index';
    public $incrementing = false;
    protected $fillable = [
        'incoterm_index',
        'incoterm_name',
        'incoterm_description',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function IncotermAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
