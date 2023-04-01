<?php

namespace App\Http\Controllers\MasterTable;

use App\Models\DataPeminjaman;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataPeminjamanRequest;
use App\Http\Requests\UpdateDataPeminjamanRequest;
use App\Models\DataBarang;
use App\Models\JenisBarang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:data-peminjaman.index')->only('index');
        $this->middleware('permission:data-peminjaman.create')->only('create', 'store');
        $this->middleware('permission:data-peminjaman.edit')->only('edit', 'update');
        $this->middleware('permission:data-peminjaman.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $dataPeminjaman = DB::table('datapeminjaman')
            ->select(
                'datapeminjaman.id',
                'datapeminjaman.peminjam_id',
                'users.name',
                'datapeminjaman.jenis_barang_id',
                'jenisbarang.jenis_barang',
                'datapeminjaman.barang_id',
                'databarang.nama_barang',
                'datapeminjaman.quantity',
                'datapeminjaman.tanggal_pinjam',
                'datapeminjaman.status',
            )
            ->leftJoin('users', 'datapeminjaman.peminjam_id', '=', 'users.id')
            ->leftJoin('jenisbarang', 'datapeminjaman.jenis_barang_id', '=', 'jenisbarang.id')
            ->leftJoin('databarang', 'datapeminjaman.barang_id', '=', 'databarang.id')
            // ->when($request->input('nama_barang'), function ($query, $nama_barang) {
            //     return $query->where('nama_barang', 'like', '%' . $nama_barang . '%');
            // })
            // ->when($request->input('harga_barang'), function ($query, $harga_barang) {
            //     return $query->where('harga_barang', 'like', '%' . $harga_barang . '%');
            // })
            // ->when($request->input('jenis_barang_id'), function ($query, $jenis_barang_id) {
            //     return $query->where('jenis_barang_id', 'like', '%' . $jenis_barang_id . '%');
            // })
            ->paginate(5);
        return view('master-table.data-peminjaman.index', compact('dataPeminjaman'));
    }

    public function create()
    {
        $dataBarang = DataBarang::all();
        $jenisBarang = JenisBarang::all();
        $user = User::all();
        return view('master-table.data-peminjaman.create')->with([
            'dataBarang' => $dataBarang,
            'jenisBarang' => $jenisBarang,
            'user' => $user,
        ]);
    }

    public function store(StoreDataPeminjamanRequest $request)
    {
        $validatedData = $request->validated();

        // Validasi quantity pada DataBarang
        $dataBarang = DataBarang::findOrFail($validatedData['barang_id']);
        if ($validatedData['quantity'] > $dataBarang->tersedia) {
            return redirect()->route('data-peminjaman.create')->withInput()->withErrors(['quantity' => 'Quantity melebihi stok yang tersedia']);
        }

        // Buat DataPeminjaman
        $dataPeminjaman = DataPeminjaman::create([
            'peminjam_id' => $validatedData['peminjam_id'],
            'jenis_barang_id' => $validatedData['jenis_barang_id'],
            'barang_id' => $validatedData['barang_id'],
            'quantity' => $validatedData['quantity'],
            'tanggal_pinjam' => $validatedData['tanggal_pinjam'],
        ]);

        // Kurangi quantity pada DataBarang dan update tersedia
        $tersedia = $dataBarang->tersedia - $validatedData['quantity'];
        $dataBarang->tersedia = $tersedia;
        $dataBarang->save();

        return redirect()->route('data-peminjaman.index')->with('success', 'Tambah Data Peminjaman Sukses');
    }



    public function edit(DataPeminjaman $dataPeminjaman)
    {
        $jenisBarang = JenisBarang::all();
        $dataBarang = DataBarang::all();
        $user = User::all();
        return view('master-table.data-peminjaman.edit')->with([
            'dataBarang' => $dataBarang,
            'jenisBarang' => $jenisBarang,
            'user' => $user,
            'dataPeminjaman' => $dataPeminjaman
        ]);
    }



    public function update(UpdateDataPeminjamanRequest $request, DataPeminjaman $dataPeminjaman)
    {
        $validatedData = $request->validated();

        // Validasi quantity pada DataBarang
        $dataBarang = DataBarang::findOrFail($validatedData['barang_id']);
        $quantityDifference = $validatedData['quantity'] - $dataPeminjaman->quantity;
        if ($quantityDifference > $dataBarang->quantity - $dataBarang->tersedia) {
            return redirect()->route('data-peminjaman.edit', $dataPeminjaman)->withInput()->withErrors(['quantity' => 'Quantity melebihi stok yang tersedia']);
        }

        // Perbarui DataPeminjaman
        $dataPeminjaman->update($validatedData);

        // Perbarui quantity pada DataBarang
        $dataBarang->tersedia = $dataBarang->quantity - DataPeminjaman::where('barang_id', $dataBarang->id)->where('status', 'Sedang Dipinjam')->sum('quantity');
        $dataBarang->save();

        return redirect()->route('data-peminjaman.index')->with('success', 'Edit Data Peminjaman Sukses');
    }






    public function destroy(DataPeminjaman $dataPeminjaman)
    {
        if ($dataPeminjaman->status === 'Sedang Dipinjam') {
            return redirect()->route('data-peminjaman.index')
                ->with('error', 'Tidak Dapat Menghapus Data Peminjaman Yang Masih Dipinjam');
        }

        try {
            $dataPeminjaman->delete();
            return redirect()->route('data-peminjaman.index')
                ->with('success', 'Hapus Data Peminjaman Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('data-peminjaman.index')
                    ->with('error', 'Tidak Dapat Menghapus Data Peminjaman Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('data-peminjaman.index')
                    ->with('success', 'Hapus Data Peminjaman Sukses');
            }
        }
    }


    public function PeminjamanBarangFilter(Request $request)
    {
        $dataBarang['dataBarang'] = DataBarang::all()->where('jenis_barang_id', $request->jenis_barang_id);
        return response()->json($dataBarang);
    }

    public function PeminjamanBarangFilterGet(Request $request)
    {
        $dataBarang['dataBarang'] = DataBarang::all()->where('jenis_barang_id', $request->jenis_barang_id);
        return response()->json($dataBarang);
    }

    public function updateStatus(DataPeminjaman $dataPeminjaman, Request $request)
    {
        if ($request->status === 'Sudah Dikembalikan') {
            // Mengembalikan quantity pada DataBarang dan update tersedia
            $dataBarang = $dataPeminjaman->dataBarang;
            $tersedia = $dataBarang->tersedia + $dataPeminjaman->quantity;

            // Validasi stok tersedia sebelum melakukan penambahan
            if ($tersedia > $dataBarang->quantity) {
                return redirect()->back()->with('error', 'Stok barang melebihi jumlah yang tersedia');
            }

            $dataBarang->tersedia = $tersedia;
            $dataBarang->save();

            $dataPeminjaman->status = $request->status;
            $dataPeminjaman->save();
        } elseif ($request->status === 'Sedang Dipinjam') {
            // Mengurangi quantity pada DataBarang dan update tersedia
            $dataBarang = $dataPeminjaman->dataBarang;

            // Validasi stok tersedia sebelum melakukan pengurangan
            if ($dataBarang->tersedia < $dataPeminjaman->quantity) {
                return redirect()->back()->with('error', 'Stok barang tidak cukup');
            }

            $tersedia = $dataBarang->tersedia - $dataPeminjaman->quantity;
            $dataBarang->tersedia = $tersedia;
            $dataBarang->save();

            $dataPeminjaman->status = $request->status;
            $dataPeminjaman->save();
        }

        return redirect()->route('data-peminjaman.index')->with('success', 'Status Peminjaman berhasil diubah');
    }
}
