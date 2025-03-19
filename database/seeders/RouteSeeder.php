<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = ([  
            // Dashboard
            ['dashboard', 'dashboard-dashboard'],
            
            // Permission
            ['configurations.permissions.index', 'permission-index'],
            ['configurations.permissions.store', 'permission-store'],
            ['configurations.permissions.update', 'permission-update'],
            ['configurations.permissions.destroy', 'permission-destroy'],

            // Role
            ['configurations.roles.index', 'role-index'],
            ['configurations.roles.store', 'role-store'],
            ['configurations.roles.update', 'role-update'],
            ['configurations.roles.destroy', 'role-destroy'],

            // Route
            ['configurations.routes.index', 'route-index'],
            ['configurations.routes.store', 'route-store'],
            ['configurations.routes.update', 'route-update'],
            ['configurations.routes.destroy', 'route-destroy'],

            // Menu Grup
            ['configurations.menuGroups.index', 'menu group-index'],
            ['configurations.menuGroups.store', 'menu group-store'],
            ['configurations.menuGroups.update', 'menu group-update'],
            ['configurations.menuGroups.destroy', 'menu group-destroy'],

            // Menu Item
            ['configurations.menuItems.index', 'menu item-index'],
            ['configurations.menuItems.store', 'menu item-store'],
            ['configurations.menuItems.update', 'menu item-update'],
            ['configurations.menuItems.destroy', 'menu item-destroy'],

            // Menu Sortable
            ['configurations.menuSortable.index', 'menu sortable-index'],
            ['configurations.menuSortable.update', 'menu sortable-update'],
        ]);  
        
        foreach ($groups as $group) {  
            Route::create([  
                'route' => $group[0],
                'permission_name' => $group[1],
            ]);  
        }  
    }
}
