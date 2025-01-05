<?php

namespace App\Models\Partners;

use App\Models\System\User;
use App\Models\System\Rating;
use App\Models\System\CommunicationMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Communication extends Model
{
    use HasFactory;

    protected $table = 'partner_communications';
    protected $primaryKey = 'communication_id';

    protected $fillable = [
        'communication_partner',
        'communication_contact',
        'communication_method',
        'communication_date',
        'communication_starting_time',
        'communication_ending_time',
        'communication_description',
        'communication_rating',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public static function getCustomActions(): array
    {
        return [];
    }

    public function CommunicationPartner()
    {
        return $this->belongsTo(Core::class, 'communication_partner', 'partner_index');
    }

    public function CommunicationContact()
    {
        return $this->belongsTo(Contact::class, 'communication_contact', 'contact_id');
    }

    public function CommunicationMethod()
    {
        return $this->belongsTo(CommunicationMethod::class, 'communication_method', 'method_index');
    }

    public function CommunicationRating()
    {
        return $this->belongsTo(Rating::class, 'communication_rating', 'rating_index');
    }

    public function CommunicationAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }
}
