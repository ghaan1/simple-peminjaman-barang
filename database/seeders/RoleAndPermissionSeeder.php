<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'dashboard']);

        Permission::create(['name' => 'user.management']);
        Permission::create(['name' => 'role.permission.management']);
        Permission::create(['name' => 'menu.management']);
        Permission::create(['name' => 'master.table.management']);
        Permission::create(['name' => 'rusak.perbaikan.management']);
        //user
        Permission::create(['name' => 'user.index']);
        Permission::create(['name' => 'user.create']);
        Permission::create(['name' => 'user.edit']);
        Permission::create(['name' => 'user.destroy']);
        Permission::create(['name' => 'user.import']);
        Permission::create(['name' => 'user.export']);

        //role
        Permission::create(['name' => 'role.index']);
        Permission::create(['name' => 'role.create']);
        Permission::create(['name' => 'role.edit']);
        Permission::create(['name' => 'role.destroy']);
        Permission::create(['name' => 'role.import']);
        Permission::create(['name' => 'role.export']);

        //permission
        Permission::create(['name' => 'permission.index']);
        Permission::create(['name' => 'permission.create']);
        Permission::create(['name' => 'permission.edit']);
        Permission::create(['name' => 'permission.destroy']);
        Permission::create(['name' => 'permission.import']);
        Permission::create(['name' => 'permission.export']);

        //assignpermission
        Permission::create(['name' => 'assign.index']);
        Permission::create(['name' => 'assign.create']);
        Permission::create(['name' => 'assign.edit']);
        Permission::create(['name' => 'assign.destroy']);

        //assingusertorole
        Permission::create(['name' => 'assign.user.index']);
        Permission::create(['name' => 'assign.user.create']);
        Permission::create(['name' => 'assign.user.edit']);

        //menu group
        Permission::create(['name' => 'menu-group.index']);
        Permission::create(['name' => 'menu-group.create']);
        Permission::create(['name' => 'menu-group.edit']);
        Permission::create(['name' => 'menu-group.destroy']);

        //menu item
        Permission::create(['name' => 'menu-item.index']);
        Permission::create(['name' => 'menu-item.create']);
        Permission::create(['name' => 'menu-item.edit']);
        Permission::create(['name' => 'menu-item.destroy']);

        //data-barang
        Permission::create(['name' => 'data-barang.index']);
        Permission::create(['name' => 'data-barang.create']);
        Permission::create(['name' => 'data-barang.edit']);
        Permission::create(['name' => 'data-barang.destroy']);

        //data-pinjaman
        Permission::create(['name' => 'data-peminjaman.index']);
        Permission::create(['name' => 'data-peminjaman.create']);
        Permission::create(['name' => 'data-peminjaman.edit']);
        Permission::create(['name' => 'data-peminjaman.destroy']);

        //data-admin
        Permission::create(['name' => 'jenis-barang.index']);
        Permission::create(['name' => 'jenis-barang.create']);
        Permission::create(['name' => 'jenis-barang.edit']);
        Permission::create(['name' => 'jenis-barang.destroy']);

        //barang-rusak
        Permission::create(['name' => 'rusak.index']);
        Permission::create(['name' => 'rusak.create']);
        Permission::create(['name' => 'rusak.edit']);
        Permission::create(['name' => 'rusak.destroy']);

        //barang-perbaikan
        Permission::create(['name' => 'perbaikan.index']);
        Permission::create(['name' => 'perbaikan.create']);
        Permission::create(['name' => 'perbaikan.edit']);
        Permission::create(['name' => 'perbaikan.destroy']);

        // create Super Admin
        $role = Role::create(['name' => 'admin-kelurahan']);
        $role->givePermissionTo(Permission::all());
        // create roles
        $roleWarga = Role::create(['name' => 'warga']);
        $roleWarga->givePermissionTo([
            'dashboard',
            'master.table.management',
            'data-peminjaman.index',
            'data-peminjaman.create',
            'data-peminjaman.edit',
            'data-peminjaman.destroy',
        ]);

        $roleRT = Role::create(['name' => 'warga-rt']);
        $roleRT->givePermissionTo([
            'dashboard',
            'master.table.management',
            'data-peminjaman.index',
            'data-peminjaman.create',
            'data-peminjaman.edit',
            'data-peminjaman.destroy',
        ]);

        $roleKelurahan = Role::create(['name' => 'admin-rt']);
        $roleKelurahan->givePermissionTo([
            'dashboard',
            'menu.management',
            'menu-group.index',
            'menu-group.create',
            'menu-group.edit',
            'menu-group.destroy',
            'menu-item.index',
            'menu-item.create',
            'menu-item.edit',
            'menu-item.destroy',
            'master.table.management',
            'data-barang.index',
            'data-barang.create',
            'data-barang.edit',
            'data-barang.destroy',
            'rusak.index',
            'rusak.create',
            'rusak.edit',
            'rusak.destroy',
            'jenis-barang.index',
            'jenis-barang.create',
            'jenis-barang.edit',
            'jenis-barang.destroy',
            'perbaikan.index',
            'perbaikan.create',
            'perbaikan.edit',
            'perbaikan.destroy',
            'rusak.perbaikan.management',
            'data-peminjaman.index',
            'data-peminjaman.create',
            'data-peminjaman.edit',
            'data-peminjaman.destroy',
        ]);



        //assign user id 1 ke super admin
        $user = User::find(1);
        $user->assignRole('admin-kelurahan');
        $user = User::find(2);
        $user->assignRole('admin-rt');
        $user = User::find(3);
        $user->assignRole('warga-rt');
        $user = User::find(4);
        $user->assignRole('warga');
    }
}
