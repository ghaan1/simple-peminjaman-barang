<?php

namespace App\Http\Controllers\MasterTable;

use App\Models\DataBarang;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataBarangRequest;
use App\Http\Requests\UpdateDataBarangRequest;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $jenisBarang = JenisBarang::all();
        $nama_barang = $request->input('nama_barang');
        $dataBarangs = DB::table('databarang')
            ->select(
                'databarang.id',
                'databarang.admin_id',
                'users.name',
                'databarang.nama_barang',
                'databarang.kode_jbs',
                'jenisbarang.kode_jb as kode_jb',
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
            ->when($request->input('jenisbarang'), function ($query, $jenisbarang) {
                return $query->whereIn('databarang.jenis_barang_id', $jenisbarang);
            })

            ->paginate(5);
        $jenisBarangSelected = $request->input('jenisbarang');
        return view('master-table.data-barang.index')->with([
            'dataBarangs' => $dataBarangs,
            'jenisBarang' => $jenisBarang,
            'jenisBarangSelected' => $jenisBarangSelected,
            'nama_barang' => $nama_barang,
        ]);
    }

    public function create()
    {
        $jenisBarangs = JenisBarang::all();
        $user = Auth::user();

        return view('master-table.data-barang.create')->with([
            'jenisBarangs' => $jenisBarangs,
            'users' => $user,
        ]);
    }

    public function store(StoreDataBarangRequest $request)
    {
    $jenis_barang = JenisBarang::find($request->jenis_barang_id);
    $item_count = DataBarang::where('jenis_barang_id', $request->jenis_barang_id)->count();
    $kode_jb = $jenis_barang->kode_jbs . '-' . ($item_count + 1);

        DataBarang::create([
            'admin_id' => $request->admin_id,
            'nama_barang' => $request->nama_barang,
            'kode_jbs' => $jenis_barang->kode_jb . $kode_jb,
            'jenis_barang_id' => $request->jenis_barang_id,
            'harga_barang' => $request->harga_barang,
            'quantity' => $request->quantity,
            'tersedia' => $request->quantity,
        ]);
        return redirect()->route('data-barang.index')->with('success', 'Tambah Data Barang Sukses');
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
            $jenis_barang_id = $dataBarang->jenis_barang_id;
            $dataBarang->delete();
            $dataBarangs = DataBarang::where('jenis_barang_id', $jenis_barang_id)->get();
            $jenis_barang = JenisBarang::find($jenis_barang_id);
            $kode_jb = $jenis_barang->kode_jb;
            foreach ($dataBarangs as $index => $dataBarang) {
                $dataBarang->update([
                    'kode_jbs' =>  $kode_jb . '-' . ($index + 1)
                ]);
            }
            return redirect()->route('data-barang.index')
                ->with('success', 'Hapus Data barang Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('data-barang.index')
                    ->with('error', 'Tidak Dapat Menghapus barang Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('data-barang.index')
                    ->with('error', 'Terjadi Kesalahan Saat Menghapus Data barang');
            }
        }
    }


    public function print(Request $request)
    {
        $jenisBarang = JenisBarang::all();
        $user = Auth::user();
        $dataBarangs = DB::table('databarang')
            ->select(
                'databarang.id',
                'databarang.admin_id',
                'users.name',
                'databarang.nama_barang',
                'databarang.kode_jbs',
                'jenisbarang.kode_jb as kode_jb',
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
            ->when($request->input('jenisbarang'), function ($query, $jenisbarang) {
                return $query->whereIn('databarang.jenis_barang_id', $jenisbarang);
            })->get();


        $pdf = PDF::loadView('master-table.data-barang.print', with([
            'dataBarangs' => $dataBarangs,
            'jenisBarang' => $jenisBarang,
            'users' => $user
        ]));
        return $pdf->stream('data-barang.pdf');
    }
}
