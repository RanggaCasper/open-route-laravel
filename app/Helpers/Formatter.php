<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;

class Formatter {
    public static function currency(string|int $amount): string
    {
        return 'Rp. '. number_format($amount, 0, ',', '.');
    }

    public static function phone(string $phone): string
    {
        $phone = preg_replace('/[^0-9+]/', '', $phone);
       
        if (substr($phone, 0, 1) == '0') {
            $phone = substr($phone, 1);
        }
       
        if (substr($phone, 0, 3) == '+62') {
            $phone = substr($phone, 3);
        }
       
        if (substr($phone, 0, 2) != '62') {
            $phone = '62'.$phone;
        }

        return $phone;
    }

    public function formattedPermission()
    {
        $groupedPermissions = [];
        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            $permissionParts = explode('-', $permission->name);
            $prefix = $permissionParts[0];
            $action = $permissionParts[1] ?? '';

            if (!isset($groupedPermissions[$prefix])) {
                $groupedPermissions[$prefix] = [];
            }
            $groupedPermissions[$prefix][] = [
                'action' => $action,
                'full_name' => $permission->name,
            ];
        }

        foreach ($groupedPermissions as &$actions) {
            usort($actions, function ($a, $b) {
                $order = ['index' => 1, 'store' => 2, 'update' => 3, 'destroy' => 4];

                $aOrder = $order[$a['action']] ?? 5;
                $bOrder = $order[$b['action']] ?? 5;

                return $aOrder <=> $bOrder;
            });
        }

        return $groupedPermissions;
    }
}