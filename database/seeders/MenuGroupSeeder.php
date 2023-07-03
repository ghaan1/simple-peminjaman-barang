<?php

namespace Database\Seeders;

use App\Models\MenuGroup;
use Illuminate\Database\Seeder;

class MenuGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // MenuGroup::factory()->count(5)->create();
        MenuGroup::insert(
            [
                [
                    'name' => 'Dashboard',
                    'icon' => 'fas fa-tachometer-alt',
                    'permission_name' => 'dashboard',
                ],
                [
                    'name' => 'Manajemen Orang',
                    'icon' => 'fas fa-users',
                    'permission_name' => 'user.management',
                ],
                [
                    'name' => 'Manajemen Peran',
                    'icon' => 'fas fa-user-tag',
                    'permisison_name' => 'role.permission.management',
                ],
                [
                    'name' => 'Manajemen Menu',
                    'icon' => 'fas fa-bars',
                    'permisison_name' => 'menu.management',
                ],
                [
                    'name' => 'Manajemen Master',
                    'icon' => 'fas fa-bars',
                    'permisison_name' => 'master.table.management',

                ],
                [
                    'name' => 'Tabel Rusak - Perbaikan Barang',
                    'icon' => 'fas fa-bars',
                    'permisison_name' => 'rusak.perbaikan.management',

                ],
            ]
        );
    }
}
