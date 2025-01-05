<?php

namespace App\Models\Sales;

use App\Models\BaseModel;
use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\Variant;


class Catalog extends BaseModel
{
    protected $description = 'Katalog proizvoda';
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

    public static function getExcludedActions(): array
    {
        return ['brisanje', 'kreiranje', 'izmjena']; 
    }

    public static function getCustomActions(): array
    {
        return [];
    }

    public function CatalogCategory()
    {
        return $this->belongsTo(Category::class, 'product_category', 'category_index');
    }

    public function CatalogBrand()
    {
        return $this->belongsTo(Brand::class, 'product_brand', 'brand_index');
    }

    public function CatalogVariants()
    {
        return $this->hasMany(Variant::class, 'variant_product', 'product_index');
    }
}
