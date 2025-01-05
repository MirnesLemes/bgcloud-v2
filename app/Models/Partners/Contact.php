<?php

namespace App\Models\Partners;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Contact extends Model
{
    use HasFactory;

    protected $table = 'partner_contacts';
    protected $primaryKey = 'contact_id';

    protected $fillable = ['contact_partner', 'contact_name', 'contact_workplace',
                            'contact_phone', 'contact_mobile', 'contact_mail', 
                            'ordering', 'created_by', 'updated_by'];

    public function ContactPartner()
    {
        return $this->belongsTo(Core::class, 'contact_partner', 'partner_index');
    }

    public function ContactAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }

}
