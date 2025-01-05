<?php

namespace App\Models\Partners;

use App\Models\System\User;
use App\Models\System\PaymentTerm;
use App\Models\System\Incoterm;
use App\Models\System\Tax;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\BaseModel;

class Core extends BaseModel
{
    use HasFactory;

    protected $description = 'Baza partnera';
    protected $table = 'partner_core';
    protected $primaryKey = 'partner_index';
    public $incrementing = false;
    protected static ?string $recordTitleAttribute = 'Partner';

    protected $fillable = [
        'partner_index',
        'partner_name',
        'partner_fullname',
        'partner_address',
        'partner_city',
        'partner_region',
        'partner_country',
        'partner_user',
        'partner_jib',
        'partner_pib',
        'partner_mbs',
        'partner_phone',
        'partner_fax',
        'partner_mail',
        'partner_web',
        'partner_contract',
        'partner_discount',
        'partner_payment_term',
        'partner_incoterm',
        'partner_tax',
        'partner_limit',
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

    public function partnerDiscount(): Attribute
    {
        return new Attribute(

            get: fn($value) => str_replace('.', ',', $value),
            set: fn($value) => str_replace(',', '.', $value)

        );
    }

    public function partnerLimit(): Attribute
    {
        return new Attribute(

            get: fn($value) => str_replace('.', ',', $value),
            set: fn($value) => str_replace(',', '.', $value)

        );
    }

    public function PartnerAuthor()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_index');
    }

    public function PartnerCity()
    {
        return $this->belongsTo(City::class, 'partner_city', 'city_index');
    }

    public function PartnerRegion()
    {
        return $this->belongsTo(Region::class, 'partner_region', 'region_index');
    }

    public function PartnerCountry()
    {
        return $this->belongsTo(Country::class, 'partner_country', 'country_index');
    }

    public function PartnerUser()
    {
        return $this->belongsTo(User::class, 'partner_user', 'user_index');
    }

    public function PartnerPaymentTerm()
    {
        return $this->belongsTo(PaymentTerm::class, 'partner_payment_term', 'term_index');
    }

    public function PartnerIncoterm()
    {
        return $this->belongsTo(Incoterm::class, 'partner_incoterm', 'incoterm_index');
    }

    public function PartnerTax()
    {
        return $this->belongsTo(Tax::class, 'partner_tax', 'tax_index');
    }

    public function PartnerContacts()
    {
        return $this->hasMany(Contact::class, 'contact_partner', 'partner_index');
    }

    public function PartnerLocations()
    {
        return $this->hasMany(Location::class, 'location_partner', 'partner_index');
    }

    public function PartnerCommunications()
    {
        return $this->hasMany(Communication::class, 'communication_partner', 'partner_index');
    }
}
