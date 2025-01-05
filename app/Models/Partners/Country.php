<?php

namespace App\Models\Partners;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Country extends BaseModel
{
    use HasFactory;

    protected $description = 'Lista država';
    protected $table = 'partner_countries';
    protected $primaryKey = 'country_index';
    public $incrementing = false;
    protected $fillable = ['country_index', 'country_name', 'created_by', 'updated_by'];

    public static function getCustomActions(): array
    {
        return [

        ];
    }

    public function CountryAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
