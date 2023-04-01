<?php

namespace App\Http\Controllers\MasterTable;

use App\Models\DataBarang;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataBarangRequest;
use App\Http\Requests\UpdateDataBarangRequest;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:data-barang.index')->only('index');
        $this->middleware('permission:data-barang.create')->only('create', 'store');
        $this->middleware('permission:data-barang.edit')->only('edit', 'update');
        $this->middleware('permission:data-barang.destroy')->only('destroy');
    }


    public function index(Request $request)
    {
        $dataBarangs = DB::table('databarang')
            ->select(
                'databarang.id',
                'databarang.admin_id',
                'users.name',
                'databarang.nama_barang',
                'jenisbarang.jenis_barang as jenis_barang',
                'databarang.jenis_barang_id',
                'databarang.harga_barang',
                'databarang.quantity',
                'databarang.tersedia',
            )
            ->leftJoin('jenisbarang', 'databarang.jenis_barang_id', '=', 'jenisbarang.id')
            ->leftJoin('users', 'databarang.admin_id', '=', 'users.id')
            ->when($request->input('nama_barang'), function ($query, $nama_barang) {
                return $query->where('nama_barang', 'like', '%' . $nama_barang . '%');
            })
            ->when($request->input('harga_barang'), function ($query, $harga_barang) {
                return $query->where('harga_barang', 'like', '%' . $harga_barang . '%');
            })
            ->when($request->input('jenis_barang_id'), function ($query, $jenis_barang_id) {
                return $query->where('jenis_barang_id', 'like', '%' . $jenis_barang_id . '%');
            })

            ->paginate(5);
        return view('master-table.data-barang.index', compact('dataBarangs'));
    }

    public function create()
    {
        $jenisBarangs = JenisBarang::all();
        return view('master-table.data-barang.create')->with([
            'jenisBarangs' => $jenisBarangs,
        ]);
    }

    public function store(StoreDataBarangRequest $request)
    {
        DataBarang::create([
            'admin_id' => $request->admin_id,
            'nama_barang' => $request->nama_barang,
            'jenis_barang_id' => $request->jenis_barang_id,
            'harga_barang' => $request->harga_barang,
            'quantity' => $request->quantity,
            'tersedia' => $request->tersedia,
        ]);
        return redirect()->route('data-barang.index')->with('success', 'Tambah Data Barang Sukses');
    }

    public function show(DataBarang $dataBarang)
    {
        //
    }


    public function edit(DataBarang $dataBarang)
    {
        $jenisBarangs = JenisBarang::all();
        return view('master-table.data-barang.edit')->with([
            'dataBarang' => $dataBarang,
            'jenisBarangs' => $jenisBarangs,
        ]);
    }

    public function update(UpdateDataBarangRequest $request, DataBarang $dataBarang)
    {
        $validate = $request->validated();
        $dataBarang->update($validate);
        return redirect()->route('data-barang.index')->with('success', 'Edit Data Barang Sukses');
    }

    public function destroy(DataBarang $dataBarang)
    {
        try {
            $dataBarang->delete();
            return redirect()->route('data-barang.index')
                ->with('success', 'Hapus Data barang Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('data-barang.index')
                    ->with('error', 'Tidak Dapat Menghapus barang Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('data-barang.index')
                    ->with('success', 'Hapus Data barang Sukses');
            }
        }
    }
}
