<?php

namespace App\Models\Products;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Category extends BaseModel
{
    use HasFactory;

    protected $description = 'Kategorije proizvoda';
    protected $table = 'product_categories';
    protected $primaryKey = 'category_index';
    public $incrementing = false;
    protected $fillable = [
        'category_index',
        'category_name',
        'category_description',
        'category_thumbnail',
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

    public function CategoryAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }

    public function CategoryProducts()
    {
        return $this->hasMany(Core::class, 'product_category', 'category_index');
    }

}
