<?php

namespace Database\Seeders;

use App\Models\MenuGroup;
use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuItems = [  
            // Main Menu
            [  
                'name' => 'Dashboard',  
                'icon' => 'ri-dashboard-line',  
                'route' => 'dashboard',  
                'permission_name' => 'dashboard-dashboard',  
                'menu_group_id' => MenuGroup::where('name', 'Main Menu')->first()->id,
                'position' => MenuItem::max('position') + 1
            ], 

            // Konfigurasi
            [  
                'name' => 'Kelola Role',  
                'icon' => 'ri-settings-line',  
                'route' => 'configurations.roles.index',  
                'permission_name' => 'role-index',  
                'menu_group_id' => MenuGroup::where('name', 'Configuration')->first()->id,
                'position' => MenuItem::max('position') + 1
            ],
            [  
                'name' => 'Kelola Perizinan',  
                'icon' => 'ri-settings-line',  
                'route' => 'configurations.permissions.index',  
                'permission_name' => 'permission-index',  
                'menu_group_id' => MenuGroup::where('name', 'Configuration')->first()->id,
                'position' => MenuItem::max('position') + 1
            ],
            [  
                'name' => 'Kelola Route',  
                'icon' => 'ri-settings-line',  
                'route' => 'configurations.routes.index',  
                'permission_name' => 'route-index',  
                'menu_group_id' => MenuGroup::where('name', 'Configuration')->first()->id,
                'position' => MenuItem::max('position') + 1
            ],
            [  
                'name' => 'Kelola Menu Grup',  
                'icon' => 'ri-settings-line',  
                'route' => 'configurations.menuGroups.index',  
                'permission_name' => 'menu group-index',  
                'menu_group_id' => MenuGroup::where('name', 'Configuration')->first()->id,
                'position' => MenuItem::max('position') + 1
            ],
            [  
                'name' => 'Kelola Menu Item',  
                'icon' => 'ri-settings-line',  
                'route' => 'configurations.menuItems.index',  
                'permission_name' => 'menu item-index',  
                'menu_group_id' => MenuGroup::where('name', 'Configuration')->first()->id,
                'position' => MenuItem::max('position') + 1
            ],

            [  
                'name' => 'Sortir Menu',  
                'icon' => 'ri-settings-line',  
                'route' => 'configurations.menuSortable.index',  
                'permission_name' => 'menu sortable-index',  
                'menu_group_id' => MenuGroup::where('name', 'Configuration')->first()->id,
                'position' => MenuItem::max('position') + 1
            ],
        ];  

        foreach ($menuItems as $group) {  
            MenuItem::create($group);  
        }  
    }
}
