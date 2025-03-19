<?php

namespace Database\Seeders;

use App\Models\MenuGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = ([  
            ['Main Menu', 'menu-menu'],  
            ['Configuration', 'configuration-menu'],  
        ]);  
        
        foreach ($groups as $group) {  
            MenuGroup::create([  
                'name' => $group[0],
                'permission_name' => $group[1],
                'position' => MenuGroup::max('position') + 1,
            ]);  
        }  
    }
}
