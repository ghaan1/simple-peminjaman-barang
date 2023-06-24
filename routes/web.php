<?php

use App\Http\Controllers\MasterTable\DataBarangController;
use App\Http\Controllers\MasterTable\DataPeminjamanController;
use App\Http\Controllers\MasterTable\JenisBarangController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Menu\MenuGroupController;
use App\Http\Controllers\Menu\MenuItemController;
use App\Http\Controllers\PerbaikanRusak\DataPerbaikanController;
use App\Http\Controllers\PerbaikanRusak\DataRusakController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\RoleAndPermission\AssignPermissionController;
use App\Http\Controllers\RoleAndPermission\AssignUserToRoleController;
use App\Http\Controllers\RoleAndPermission\ExportPermissionController;
use App\Http\Controllers\RoleAndPermission\ExportRoleController;
use App\Http\Controllers\RoleAndPermission\ImportPermissionController;
use App\Http\Controllers\RoleAndPermission\ImportRoleController;
use App\Http\Controllers\RoleAndPermission\PermissionController;
use App\Http\Controllers\RoleAndPermission\RoleController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('auth/login');
})->name('login');

Route::get('/register', function () {
    return view('auth/register');
})->name('register');


Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.edit');
    Route::PUT('/update-profile-information', [ProfileUserController::class, 'update'])
        ->name('profile.user.update');



    Route::get('/master-table-management/data-peminjaman', function () {
        return view('master-table.data-peminjaman.index', ['users' => User::get(),]);
    });
    //user list

    Route::prefix('user-management')->group(function () {
        Route::resource('user', UserController::class);
        Route::match(['get', 'post'], '/verify-email/{id}/{hash}', [UserController::class, 'verifyEmail'])
            ->name('user.verify-email');
        Route::delete('/verify-email/{id}/{hash}', [UserController::class, 'verifyEmail'])
            ->name('user.delete-verify-email');
        Route::post('import', [UserController::class, 'import'])->name('user.import');
        Route::get('export', [UserController::class, 'export'])->name('user.export');
        Route::get('demo', DemoController::class)->name('user.demo');
    });

    Route::prefix('menu-management')->group(function () {
        Route::resource('menu-group', MenuGroupController::class);
        Route::resource('menu-item', MenuItemController::class);
    });

    Route::group(['prefix' => 'role-and-permission'], function () {
        //role
        Route::resource('role', RoleController::class);
        Route::get('role/export', ExportRoleController::class)->name('role.export');
        Route::post('role/import', ImportRoleController::class)->name('role.import');

        //permission
        Route::resource('permission', PermissionController::class);
        Route::get('permission/export', ExportPermissionController::class)->name('permission.export');
        Route::post('permission/import', ImportPermissionController::class)->name('permission.import');

        //assign permission
        Route::get('assign', [AssignPermissionController::class, 'index'])->name('assign.index');
        Route::get('assign/create', [AssignPermissionController::class, 'create'])->name('assign.create');
        Route::get('assign/{role}/edit', [AssignPermissionController::class, 'edit'])->name('assign.edit');
        Route::put('assign/{role}', [AssignPermissionController::class, 'update'])->name('assign.update');
        Route::post('assign', [AssignPermissionController::class, 'store'])->name('assign.store');

        //assign user to role
        Route::get('assign-user', [AssignUserToRoleController::class, 'index'])->name('assign.user.index');
        Route::get('assign-user/create', [AssignUserToRoleController::class, 'create'])->name('assign.user.create');
        Route::post('assign-user', [AssignUserToRoleController::class, 'store'])->name('assign.user.store');
        Route::get('assing-user/{user}/edit', [AssignUserToRoleController::class, 'edit'])->name('assign.user.edit');
        Route::put('assign-user/{user}', [AssignUserToRoleController::class, 'update'])->name('assign.user.update');
    });

    Route::prefix('master-table-management')->group(function () {
        Route::resource('jenis-barang', JenisBarangController::class);
        Route::resource('data-barang', DataBarangController::class);
        Route::get('/data-barang-pdf', [DataBarangController::class, 'print'])->name('data-barang.print');
        Route::resource('data-peminjaman', DataPeminjamanController::class);
        Route::post('peminjaman-barang-filter', [DataPeminjamanController::class, 'PeminjamanBarangFilter'])
            ->name('data-peminjaman-barang.filters');
        Route::get('peminjaman-barang-filter-get', [DataPeminjamanController::class, 'PeminjamanBarangFilterGet'])
            ->name('data-peminjaman-barang-get.filters');
        Route::patch('/data-peminjaman/{dataPeminjaman}/update-status', [DataPeminjamanController::class, 'updateStatus'])->name('data-peminjaman.update-status');
        Route::get('/data-peminjaman-pdf', [DataPeminjamanController::class, 'print'])->name('data-peminjaman.print');
    });

    Route::prefix('rusak-perbaikan-management')->group(function () {
        Route::resource('rusak', DataRusakController::class);
        Route::post('get-data-barang-quantity', [DataRusakController::class, 'getDataBarangQuantity'])
            ->name('get-data-barang-quantity');
        Route::post('get-barang-peminjam', [DataRusakController::class, 'getBarangPeminjam'])->name('get-barang-peminjam');
        Route::post('get-user-role', [DataRusakController::class, 'getUserFromRole'])->name('get-user-role');
        Route::resource('perbaikan', DataPerbaikanController::class);
        Route::get('/perbaikan-pdf', [DataPerbaikanController::class, 'print'])->name('perbaikan.print');
    });
});
