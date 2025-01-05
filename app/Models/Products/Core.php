<?php

namespace App\Models\Products;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Core extends BaseModel
{
    use HasFactory;

    protected $description = 'Baza proizvoda';
    protected $table = 'product_core';
    protected $primaryKey = 'product_index';
    public $incrementing = false;
    protected $fillable = [
        'product_index',
        'product_category',
        'product_brand',
        'product_name',
        'product_description',
        'product_text',
        'product_tags',
        'product_thumbnail',
        'product_video',
        'product_a1_name',
        'product_a2_name',
        'product_a3_name',
        'product_a4_name',
        'product_a1_values',
        'product_a2_values',
        'product_a3_values',
        'product_a4_values',
        'published',
        'featured',
        'onsale',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public static function getCustomActions(): array
    {
        return [
            'import' => 'Uvoz podataka',
        ];
    }

    public function ProductAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }

    public function ProductCategory()
    {
        return $this->belongsTo(Category::class, 'product_category', 'category_index');
    }

    public function ProductBrand()
    {
        return $this->belongsTo(Brand::class, 'product_brand', 'brand_index');
    }

    public function ProductVariants()
    {
        return $this->hasMany(Variant::class, 'variant_product', 'product_index');
    }

    // public function ProductAttributes()
    // {
    //     return $this->hasMany(VariantAttributes::class, 'product_index');
    // }

    // public function QuotationItems()
    // {
    //     return $this->hasMany(\App\Models\Quotations\Item::class, 'product_id');
    // }

}
