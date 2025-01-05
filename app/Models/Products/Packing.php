<?php

namespace App\Models\Products;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Packing extends BaseModel
{
    use HasFactory;

    protected $description = 'Vrste pakovanja';
    protected $table = 'product_packings';
    protected $primaryKey = 'packing_index';
    public $incrementing = false;
    protected $fillable = [
        'packing_index',
        'packing_name',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public static function getCustomActions(): array
    {
        return [];
    }

    public function PackingAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
