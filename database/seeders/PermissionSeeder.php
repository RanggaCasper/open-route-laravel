<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'menu-menu',
            'configuration-menu',

            // Dashboard
            'dashboard-dashboard',

            // Permission
            'permission-index',
            'permission-store',
            'permission-update',
            'permission-destroy',

            // Role
            'role-index',
            'role-store',
            'role-update',
            'role-destroy',

            // Route
            'route-index',
            'route-store',
            'route-update',
            'route-destroy',

            // Menu Grup
            'menu group-index',
            'menu group-store',
            'menu group-update',
            'menu group-destroy',

            // Menu Item
            'menu item-index',
            'menu item-store',
            'menu item-update',
            'menu item-destroy',

            // Sortir Menu
            'menu sortable-index',
            'menu sortable-update',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
