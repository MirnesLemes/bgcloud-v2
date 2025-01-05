<?php

namespace App\Helpers;

class StaticLists
{
    public static function workYears(): array
    {
        return [
            '2022' => '2022',
            '2023' => '2023',
            '2024' => '2024',
        ];
    }

    public static function DocumentTypes(): array
    {
        return [
            'NRD' => 'Narudžba dobavljaču',
        ];
    }

    public static function getPermissionDescriptions(): array
    {
        return [
            'viewAny' => 'Prikaz navigacije',
            'view' => 'Pregled resursa',
            'create' => 'Kreiranje',
            'update' => 'Izmjena',
            'delete' => 'Brisanje',
        ];
    }
}
