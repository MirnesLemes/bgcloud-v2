<?php

namespace App\Models\System;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasName;
use Illuminate\Support\Facades\Storage;

/**
 * @method bool can(string $ability, array|mixed $arguments = [])
 */

class User extends Authenticatable implements HasAvatar, HasName, FilamentUser
{
    use HasFactory, Notifiable;

    protected $description = 'Korisnici sistema';

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->approved == 1;
    }

    public function getEmailAttribute()
    {
        return $this->user_email;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['user_email'] = strtolower($value);
    }

    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public function getFilamentName(): string
    {
        return "{$this->user_name}";
    }

    protected $table = 'system_users';
    protected $primaryKey = 'user_index';
    public $incrementing = false;

    protected $fillable = [
        'user_index',
        'user_name',
        'user_email',
        'user_password',
        'user_role',
        'approved',
        'avatar_url',
        'ordering'
    ];

    protected $hidden = ['user_password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'user_password' => 'hashed'];

    public static function getTableName() 
    {
        return with(new static)->getTable();
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

    public function UserRole()
    {
        return $this->belongsTo(UserRole::class, 'user_role', 'role_index');
    }
}
