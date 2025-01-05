<?php

namespace App\Models\Partners;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
   
    protected $table = 'partner_locations';
    protected $primaryKey = 'location_id';

    protected $fillable = ['location_partner', 'location_name', 'location_jib', 'location_address', 'location_city', 
                            'location_geolocation', 'ordering', 'created_by', 'updated_by'];

    public function LocationPartner()
    {
        return $this->belongsTo(Core::class, 'location_partner', 'partner_index');
    }

    public function LocationCity()
    {
        return $this->belongsTo(City::class, 'location_city', 'city_index');
    }

    public function LocationAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
