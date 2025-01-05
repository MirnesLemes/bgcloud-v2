<?php

namespace App\Models\Partners;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class City extends BaseModel
{
    use HasFactory;

    protected $description = 'Lista gradova';
    protected $table = 'partner_cities';
    protected $primaryKey = 'city_index';
    public $incrementing = false;

    protected $fillable = [
        'city_index',
        'city_name',
        'city_zip',
        'city_country',
        'city_region',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public static function getCustomActions(): array
    {
        return [

        ];
    }

    public function CityCountry()
    {
        return $this->belongsTo(Country::class, 'city_country', 'country_index');
    }

    public function CityRegion()
    {
        return $this->belongsTo(Region::class, 'city_region', 'region_index');
    }

    public function CityAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
