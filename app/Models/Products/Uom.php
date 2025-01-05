<?php

namespace App\Models\Products;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Uom extends BaseModel
{
    use HasFactory;

    protected $description = 'Jedinice mjere';
    protected $table = 'product_uoms';
    protected $primaryKey = 'uom_index';
    public $incrementing = false;
    protected $fillable = ['uom_index', 'uom_name', 'ordering', 
    'created_by', 'updated_by'];

    public static function getCustomActions(): array
    {
        return [];
    }

    public function UomAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }

}
