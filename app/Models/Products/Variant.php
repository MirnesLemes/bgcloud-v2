<?php

namespace App\Models\Products;

use App\Models\System\User;
use App\Models\Products\Core;
use App\Models\Products\Category;
use App\Models\Products\Brand;
use App\Models\Products\Uom;
use App\Models\Products\Packing;
use App\Models\Products\VariantAttributes;
use App\Models\Partners\Country;
use App\Models\System\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Variant extends BaseModel
{
    use HasFactory;

    protected $description = 'Varijante proizvoda';
    protected $table = 'product_variants';
    protected $primaryKey = 'variant_index';
    public $incrementing = false;
    protected $fillable = [
        'variant_index',
        'variant_category',
        'variant_product',
        'variant_uom',
        'variant_packing',
        'variant_origin',
        'variant_code',
        'variant_name',
        'variant_barcode',
        'variant_hscode',
        'uom_quantity',
        'variant_weight',
        'variant_brand',
        'variant_price',
        'variant_taxprice',
        'variant_expprice',
        'variant_expprice_currency',
        'variant_purprice',
        'variant_supprice',
        'variant_supprice_currency',
        'variant_a1_index',
        'variant_a1_value',
        'variant_a2_index',
        'variant_a2_value',
        'variant_a3_index',
        'variant_a3_value',
        'variant_a4_index',
        'variant_a4_value',
        'created_by',
        'updated_by'
    ];

    public static function getCustomActions(): array
    {
        return [
            'import' => 'Uvoz podataka',
        ];
    }

    // public function variantWeight(): Attribute
    // {
    //     return new Attribute(

    //         get: fn($value) => str_replace('.', ',', $value),
    //         set: fn($value) => str_replace(',', '.', $value)

    //     );
    // }

    // public function variantPrice(): Attribute
    // {
    //     return new Attribute(

    //         get: fn($value) => str_replace('.', ',', $value),
    //         set: fn($value) => str_replace(',', '.', $value)

    //     );
    // }

    // public function variantTaxprice(): Attribute
    // {
    //     return new Attribute(

    //         get: fn($value) => str_replace('.', ',', $value),
    //         set: fn($value) => str_replace(',', '.', $value)

    //     );
    // }

    // public function variantExpprice(): Attribute
    // {
    //     return new Attribute(

    //         get: fn($value) => str_replace('.', ',', $value),
    //         set: fn($value) => str_replace(',', '.', $value)

    //     );
    // }

    // public function variantPurprice(): Attribute
    // {
    //     return new Attribute(

    //         get: fn($value) => str_replace('.', ',', $value),
    //         set: fn($value) => str_replace(',', '.', $value)

    //     );
    // }

    // public function variantSupprice(): Attribute
    // {
    //     return new Attribute(

    //         get: fn($value) => str_replace('.', ',', $value),
    //         set: fn($value) => str_replace(',', '.', $value)

    //     );
    // }

    public function VariantAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }

    public function VariantProduct()
    {
        return $this->belongsTo(Core::class, 'variant_product', 'product_index');
    }

    public function VariantCategory()
    {
        return $this->belongsTo(Category::class, 'variant_category', 'category_index');
    }

    public function VariantBrand()
    {
        return $this->belongsTo(Brand::class, 'variant_brand', 'brand_index');
    }

    public function VariantUom()
    {
        return $this->belongsTo(Uom::class, 'variant_uom', 'uom_index');
    }

    public function VariantPacking()
    {
        return $this->belongsTo(Packing::class, 'variant_packing', 'packing_index');
    }

    public function VariantCountry()
    {
        return $this->belongsTo(Country::class, 'variant_origin', 'country_index');
    }

    public function VariantExpPriceCurrency()
    {
        return $this->belongsTo(Currency::class, 'variant_expprice_currency', 'currency_index');
    }

    public function VariantSupPriceCurrency()
    {
        return $this->belongsTo(Currency::class, 'variant_supprice_currency', 'currency_index');
    }


    // public function VariantAttributes()
    // {
    //     return $this->hasMany(VariantAttributes::class, 'variant_index');
    // }

}
