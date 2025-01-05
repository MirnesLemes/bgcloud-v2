<?php

namespace App\Models\Products;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Brand extends BaseModel
{
    use HasFactory;

    protected $description = 'Brendovi proizvoda';
    protected $table = 'product_brands';
    protected $primaryKey = 'brand_index';
    public $incrementing = false;
    protected $fillable = [
        'brand_index',
        'brand_name',
        'brand_description',
        'brand_logo',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public static function getCustomActions(): array
    {
        return [];
    }
    
    public function BrandAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }

    // public function BrandProducts()
    // {
    //     return $this->hasMany(Core::class, 'brand_index');
    // }

}
