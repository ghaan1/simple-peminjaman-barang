<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // MenuItem::factory()->count(10)->create();
        MenuItem::insert(
            [
                [
                    'name' => 'User List',
                    'route' => 'user-management/user',
                    'permission_name' => 'user.index',
                    'menu_group_id' => 1,
                ],
                [
                    'name' => 'Role List',
                    'route' => 'role-and-permission/role',
                    'permission_name' => 'role.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Permission List',
                    'route' => 'role-and-permission/permission',
                    'permission_name' => 'permission.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Permission To Role',
                    'route' => 'role-and-permission/assign',
                    'permission_name' => 'assign.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'User To Role',
                    'route' => 'role-and-permission/assign-user',
                    'permission_name' => 'assign.user.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Menu Group',
                    'route' => 'menu-management/menu-group',
                    'permission_name' => 'menu-group.index',
                    'menu_group_id' => 3,
                ],
                [
                    'name' => 'Menu Item',
                    'route' => 'menu-management/menu-item',
                    'permission_name' => 'menu-item.index',
                    'menu_group_id' => 3,
                ],
                [
                    'name' => 'Data barang',
                    'route' => 'master-table-management/data-barang',
                    'permission_name' => 'jenis-barang.index',
                    'menu_group_id' => 4,
                ],
                [
                    'name' => 'Jenis barang',
                    'route' => 'master-table-management/jenis-barang',
                    'permission_name' => 'data-barang.index',
                    'menu_group_id' => 4,
                ],
                [
                    'name' => 'Data Peminjaman',
                    'route' => 'master-table-management/data-peminjaman',
                    'permission_name' => 'data-peminjaman.index',
                    'menu_group_id' => 4,
                ],

            ]
        );
    }
}
