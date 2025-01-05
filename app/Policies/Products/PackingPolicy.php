<?php

namespace App\Policies\Products;

use App\Models\Products\Packing as PolicyModel;
use App\Models\System\User;

class PackingPolicy
{
    // Provjere su urađene u BaseModel a svaki model naslijeđuje BaseModel
    // Na ovaj način provjere radimo sistematično a kod je apstraktovan

    public function viewAny(User $user): bool
    {
        return PolicyModel::hasPermission($user->user_role, 'tabela');
    }

    public function view(User $user): bool
    {
        return PolicyModel::hasPermission($user->user_role, 'pregled');
    }

    public function create(User $user): bool
    {
        return PolicyModel::hasPermission($user->user_role, 'kreiranje');
    }

    public function update(User $user): bool
    {
        return PolicyModel::hasPermission($user->user_role, 'izmjena');
    }

    public function delete(User $user): bool
    {
        return PolicyModel::hasPermission($user->user_role, 'brisanje');
    }


}

