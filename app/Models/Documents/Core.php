<?php

namespace App\Models\Documents;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\Partners\Core as Partner;

class Core extends BaseModel
{
    use HasFactory;

    protected $description = 'Upravljanje dokumentima';
    protected $table = 'document_core';
    protected $primaryKey = 'document_id';

    protected $fillable = [
        'document_name',
        'document_date',
        'document_category',
        'document_partner',
        'document_description',
        'document_users',
        'document_url',
        'document_full_url',
        'document_type',
        'created_by',
        'updated_by'
    ];

    public static function getCustomActions(): array
    {
        return [];
    }

    protected $casts = [
        'document_users' => 'array'
    ];

    public function DocumentAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }

    public function DocumentCategory()
    {
        return $this->belongsTo(Category::class, 'document_category', 'category_index');
    }

    public function DocumentPartner()
    {
        return $this->belongsTo(Partner::class, 'document_partner', 'partner_index');
    }
}
