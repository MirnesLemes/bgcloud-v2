<?php

namespace App\Models\Partners;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Region extends BaseModel  
{
    use HasFactory;

    protected $description = 'Komercijalni regioni';
    protected $table = 'partner_regions';
    protected $primaryKey = 'region_index';
    public $incrementing = false;
    protected $fillable = ['region_index', 'region_name', 'region_user', 'ordering', 'created_by', 'updated_by'];

    public static function getCustomActions(): array
    {
        return [

        ];
    }
    
    public function RegionUser()
    {
        return $this->belongsTo(User::class, 'region_user', 'user_index');
    }

    public function RegionAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
