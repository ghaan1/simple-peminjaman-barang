<?php

namespace App\Http\Controllers\PerbaikanRusak;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataRusakRequest;
use App\Http\Requests\UpdateDataRusakRequest;
use App\Models\DataBarang;
use App\Models\DataPeminjaman;
use App\Models\DataPerbaikan;
use App\Models\DataRusak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataRusakController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:rusak.index')->only('index');
        $this->middleware('permission:rusak.create')->only('create', 'store');
        $this->middleware('permission:rusak.edit')->only('edit', 'update');
        $this->middleware('permission:rusak.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $dataRusak = DB::table('data_rusaks')->select(
            'data_rusaks.id',
            'data_rusaks.user_id',
            'users.name',
            'roles.name as role_name',
            'data_rusaks.barang_id',
            'data_rusaks.quantity_rusak',
            'data_rusaks.status_rusak',
            'databarang.nama_barang',
        )->join('databarang', 'data_rusaks.barang_id', '=', 'databarang.id')
            ->join('users', 'data_rusaks.user_id', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->paginate(5);

        return view('rusak-perbaikan.rusak.index', compact('dataRusak'));
    }

    public function create()
    {
        $userId = Auth::id();
        $role = DB::table('model_has_roles')
            ->where('model_id', $userId)
            ->select('roles.name', 'roles.id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->first();
        $user = DB::table('users')->where('id', $userId)->first();
        $dataBarang = DB::table('databarang')->get();
        return view('rusak-perbaikan.rusak.create')->with([
            'dataBarang' => $dataBarang,
            'user' => $user,
            'role' => $role,
        ]);
    }


    public function store(StoreDataRusakRequest $request)
    {
        $dataRusak = DataRusak::create([
            'barang_id' => $request->barang_id,
            'quantity_rusak' => $request->quantity_rusak,
            'status_rusak' => 'rusak',
            'user_id' => $request->user_id,
        ]);

        DataPerbaikan::create([
            'rusak_id' => $dataRusak->id,
        ]);

        $dataBarang = DataBarang::find($request->barang_id);
        $dataBarang->tersedia -= $request->quantity_rusak;
        $dataBarang->save();
        return redirect()->route('rusak.index')->with('success', 'Tambah Data Rusak Sukses');
    }

    public function destroy(DataRusak $rusak)
    {
        if ($rusak->status_rusak === 'rusak') {
            return redirect()->route('rusak.index')
                ->with('error', 'Tidak Dapat Menghapus Data Barang Rusak Yang Masih Berstatus Rusak');
        }

        try {
            $rusak->delete();
            return redirect()->route('rusak.index')
                ->with('success', 'Hapus Data Barang Rusak Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('rusak.index')
                    ->with('error', 'Tidak Dapat Menghapus Data Barang Rusak Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('rusak.index')
                    ->with('error', 'Gagal menghapus data barang rusak');
            }
        }
    }

    public function getDataBarangQuantity(Request $request)
    {
        $databarang['databarang'] = Databarang::where('id', $request->barang_id)
            ->select('quantity', 'tersedia')
            ->first();
        return response()->json($databarang);
    }

    public function getBarangPeminjam(Request $request)
    {
        $dataPeminjaman['dataPeminjaman'] = DataBarang::where('admin_id', $request->id)
            ->select('databarang.id', 'databarang.nama_barang')
            // ->leftJoin('databarang', 'datapeminjaman.barang_id', '=', 'databarang.id')
            ->get();
        return response()->json($dataPeminjaman);
    }

    public function getUserFromRole(Request $request)
    {
        $userRole['userRole'] = DB::table('model_has_roles')
            ->select('model_has_roles.model_id', 'users.name', 'users.id')
            ->leftJoin('users', 'model_has_roles.model_id', '=', 'users.id')
            ->where('role_id', $request->id)
            ->get();
        return response()->json($userRole);
    }
}
