<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRolePermission extends Model
{
    use HasFactory;

    protected $description = 'Dozvole za korisničke uloge';
    protected $table = 'system_roles_permissions';
    protected $primaryKey = 'permission_id';
    protected $fillable = [
        'permission_role',
        'permission_model',
        'permission_permissions',
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    protected $casts = [
        'permission_permissions' => 'array',
    ];

    public function PermissionRole()
    {
        return $this->belongsTo(UserRole::class, 'permission_role', 'role_index');
    }

    public function PermissionModel()
    {
        return $this->belongsTo(ModelList::class, 'permission_model', 'model_id');
    }
}
