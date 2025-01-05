<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $description = 'Korisničke uloge';
    protected $table = 'system_users_roles';
    protected $primaryKey = 'role_index';
    public $incrementing = false;
    protected $fillable = [
        'role_index',
        'role_name',
        'ordering'
    ];

    public static function getTableName() 
    {
        return with(new static)->getTable();
    }

    public function UserRolePermissions()
    {
        return $this->hasMany(UserRolePermission::class, 'permission_role', 'role_index');
    }

}
