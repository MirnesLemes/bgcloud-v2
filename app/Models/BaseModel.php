<?php

namespace App\Models;

use App\Models\System\ModelList;
use App\Models\System\UserRolePermission;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{

    public static function getStandardActions(): array
    {
        return [
            'tabela' => 'Pregled tabele',
            'pregled' => 'Pregled podatka',
            'kreiranje' => 'Kreiranje podatka',
            'izmjena' => 'Izmjena podatka',
            'brisanje' => 'Brisanje podatka',
        ];
    }

    // Lista akcija koje model može isključiti
    public static function getExcludedActions(): array
    {
        return [];
    }

    // Custom akcije specifične za model
    public static function getCustomActions(): array
    {
        return [];
    }

    // Kombinacija standardnih i custom akcija, minus isključene
    public static function getAllActions(): array
    {
        $excludedActions = static::getExcludedActions();
        $standardActions = array_filter(static::getStandardActions(), function ($key) use ($excludedActions) {
            return !in_array($key, $excludedActions);
        }, ARRAY_FILTER_USE_KEY);

        return array_merge($standardActions, static::getCustomActions());
    }


    public static function getModelId(): ?int
    {
        $modelNamespace = static::class;
        $model = ModelList::where('model_namespace', $modelNamespace)->first();

        if (!$model) {
            dd("Model nije pronađen za namespace: $modelNamespace");
        }

        return $model?->model_id;
    }

    public static function hasPermission(string $role, string $action): bool
    {
        $modelId = static::getModelId();

        if (!$modelId) {
            return false; // Model nije pronađen
        }

        $permissions = UserRolePermission::where('permission_model', $modelId)
            ->where('permission_role', $role)
            ->first();

        if (!$permissions || !is_array($permissions->permission_permissions)) {
            return false; // Nema dozvola ili permisije nisu ispravno definisane
        }

        return in_array($action, $permissions->permission_permissions);
    }
}
