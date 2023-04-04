<?php

namespace App\Http\Controllers\MasterTable;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJenisBarangRequest;
use App\Http\Requests\UpdateJenisBarangRequest;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class JenisBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:jenis-barang.index')->only('index');
        $this->middleware('permission:jenis-barang.create')->only('create', 'store');
        $this->middleware('permission:jenis-barang.edit')->only('edit', 'update');
        $this->middleware('permission:jenis-barang.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $jenisBarangs = DB::table('jenisbarang')
            ->when($request->input('jenis_barang'), function ($query, $jenis_barang) {
                return $query->where('jenis_barang', 'like', '%' . $jenis_barang . '%');
            })->paginate(5);
        return view('master-table.jenis-barang.index', compact('jenisBarangs'));
    }

    public function create()
    {
        return view('master-table.jenis-barang.create');
    }

    public function store(StoreJenisBarangRequest $request)
    {
        JenisBarang::create([
            'kode_jb' => $request->kode_jb,
            'jenis_barang' => $request->jenis_barang,
        ]);
        return redirect()->route('jenis-barang.index')->with('success', 'Tambah Data Barang Sukses');
    }

    public function edit(JenisBarang $jenisBarang)
    {
        return view('master-table.jenis-barang.edit')->with([
            'jenisBarang' => $jenisBarang
        ]);
    }

    public function update(UpdateJenisBarangRequest $request, JenisBarang $jenisBarang)
    {
        $validate = $request->validated();
        $jenisBarang->update($validate);
        return redirect()->route('jenis-barang.index')->with('success', 'Edit Jenis Barang Sukses');
    }

    public function destroy(JenisBarang $jenisBarang)
    {
        try {
            $jenisBarang->delete();
            return redirect()->route('jenis-barang.index')
                ->with('success', 'Hapus Data Jenis Barang Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('jenis-barang.index')
                    ->with('error', 'Tidak Dapat Menghapus Jenis Barang Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('jenis-barang.index')
                    ->with('success', 'Hapus Jenis Barang Sukses');
            }
        }
    }
}
