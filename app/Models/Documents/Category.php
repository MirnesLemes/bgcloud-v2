<?php

namespace App\Models\Documents;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Category extends BaseModel
{
    use HasFactory;

    protected $description = 'Kategorije dokumenata';
    protected $table = 'document_categories';
    protected $primaryKey = 'category_index';
    public $incrementing = false;

    protected $fillable = [
        'category_index',
        'category_name',
        'category_description',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public static function getCustomActions(): array
    {
        return [];
    }
    
    public function CategoryAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
