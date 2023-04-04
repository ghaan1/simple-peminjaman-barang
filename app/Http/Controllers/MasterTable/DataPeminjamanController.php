<?php

namespace App\Http\Controllers\MasterTable;

use App\Models\DataPeminjaman;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataPeminjamanRequest;
use App\Http\Requests\UpdateDataPeminjamanRequest;
use App\Models\DataBarang;
use App\Models\JenisBarang;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $users = User::all();
        $jenisBarang = JenisBarang::all();
        $nama_barang = $request->input('nama_barang');
        $status = ['Sedang Dipinjam', 'Sudah Dikembalikan'];


        $user = Auth::user();

        if ($user->hasRole('super-admin')) {
            $dataPeminjaman = DB::table('datapeminjaman')
                ->select(
                    'datapeminjaman.id',
                    'datapeminjaman.peminjam_id',
                    'users.name',
                    'datapeminjaman.jenis_barang_id',
                    'databarang.kode_jbs',
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
                ->when($request->input('databarang'), function ($query, $databarang) {
                    return $query->whereIn('datapeminjaman.barang_id', $databarang);
                })
                ->when($request->input('jenisbarang'), function ($query, $jenisbarang) {
                    return $query->whereIn('datapeminjaman.jenis_barang_id', $jenisbarang);
                })
                ->when($request->input('users'), function ($query, $users) {
                    return $query->whereIn('datapeminjaman.peminjam_id', $users);
                })
                ->when($request->input('status'), function ($query, $status) {
                    return $query->whereIn('datapeminjaman.status', $status);
                })
                ->when($request->input('nama_barang'), function ($query, $nama_barang) {
                    return $query->where('nama_barang', 'like', '%' . $nama_barang . '%');
                })
                ->paginate(5);
            $dataBarangSelected = $request->input('databarang');
            $jenisBarangSelected = $request->input('jenisbarang');
            $userSelected = $request->input('users');
            $statusSelected = $request->input('status');
        } else {
            $dataPeminjaman = DB::table('datapeminjaman')
                ->select(
                    'datapeminjaman.id',
                    'datapeminjaman.peminjam_id',
                    'users.name',
                    'datapeminjaman.jenis_barang_id',
                    'jenisbarang.jenis_barang',
                    'databarang.kode_jbs',
                    'datapeminjaman.barang_id',
                    'databarang.nama_barang',
                    'datapeminjaman.quantity',
                    'datapeminjaman.tanggal_pinjam',
                    'datapeminjaman.status',
                )
                ->leftJoin('users', 'datapeminjaman.peminjam_id', '=', 'users.id')
                ->leftJoin('jenisbarang', 'datapeminjaman.jenis_barang_id', '=', 'jenisbarang.id')
                ->leftJoin('databarang', 'datapeminjaman.barang_id', '=', 'databarang.id')
                ->where('users.name', '=', $user->name)
                ->leftJoin('users as u2', 'datapeminjaman.peminjam_id', '=', 'u2.id')
                ->leftJoin('jenisbarang as jb', 'datapeminjaman.jenis_barang_id', '=', 'jb.id')
                ->leftJoin('databarang as db', 'datapeminjaman.barang_id', '=', 'db.id')
                ->when($request->input('databarang'), function ($query, $databarang) {
                    return $query->whereIn('datapeminjaman.barang_id', $databarang);
                })
                ->when($request->input('jenisbarang'), function ($query, $jenisbarang) {
                    return $query->whereIn('datapeminjaman.jenis_barang_id', $jenisbarang);
                })
                ->when($request->input('users'), function ($query, $users) {
                    return $query->whereIn('datapeminjaman.peminjam_id', $users);
                })
                ->when($request->input('status'), function ($query, $status) {
                    return $query->whereIn('datapeminjaman.status', $status);
                })
                ->when($request->input('nama_barang'), function ($query, $nama_barang) {
                    return $query->where('nama_barang', 'like', '%' . $nama_barang . '%');
                })
                ->paginate(5);
            $dataBarangSelected = $request->input('databarang');
            $jenisBarangSelected = $request->input('jenisbarang');
            $userSelected = $request->input('users');
            $statusSelected = $request->input('status');
        }

        return view('master-table.data-peminjaman.index')->with([
            'nama_barang' => $nama_barang,
            'statusSelected' => $statusSelected,
            'status' => $status,
            'userSelected' => $userSelected,
            'jenisBarangSelected' => $jenisBarangSelected,
            'dataBarangSelected' => $dataBarangSelected,
            'dataPeminjaman' => $dataPeminjaman,
            'jenisBarang' => $jenisBarang,
            'user' => $user,
            'users' => $users,
        ]);
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
        $dataBarang = DataBarang::findOrFail($validatedData['barang_id']);
        if ($validatedData['quantity'] > $dataBarang->tersedia) {
            return redirect()->route('data-peminjaman.create')
                ->withInput()->withErrors(['quantity' => 'Quantity melebihi stok yang tersedia']);
        }
        $dataPeminjaman = DataPeminjaman::create([
            'peminjam_id' => $validatedData['peminjam_id'],
            'jenis_barang_id' => $validatedData['jenis_barang_id'],
            'barang_id' => $validatedData['barang_id'],
            'quantity' => $validatedData['quantity'],
            'tanggal_pinjam' => $validatedData['tanggal_pinjam'],
        ]);
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
        if ($dataPeminjaman->status == 'Sedang Dipinjam') {
            return redirect()->route('data-peminjaman.edit', $dataPeminjaman)
                ->with('error', 'Barang Masih Dipinjam');
        }
        $validatedData = $request->validated();
        $dataBarang = DataBarang::findOrFail($validatedData['barang_id']);
        $quantityDifference = $validatedData['quantity'] - $dataPeminjaman->quantity;
        $tersedia = $dataBarang->quantity - DataPeminjaman::where('barang_id', $dataBarang->id)
            ->where('status', 'Sedang Dipinjam')->sum('quantity');
        if ($quantityDifference > $tersedia) {
            return redirect()->route('data-peminjaman.edit', $dataPeminjaman)->withInput()
                ->withErrors(['quantity' => 'Quantity melebihi stok yang tersedia']);
        }
        $dataPeminjaman->update($validatedData);
        $dataBarang->tersedia = max(0, $dataBarang->quantity - DataPeminjaman::where('barang_id', $dataBarang->id)
            ->where('status', 'Sedang Dipinjam')->sum('quantity'));
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

    public function print(Request $request)
    {
        $user = Auth::user();
        $query = DB::table('datapeminjaman')
            ->select(
                'datapeminjaman.id',
                'datapeminjaman.peminjam_id',
                'users.name',
                'datapeminjaman.jenis_barang_id',
                'jenisbarang.jenis_barang',
                'users.name',
                'datapeminjaman.barang_id',
                'databarang.nama_barang',
                'datapeminjaman.quantity',
                'datapeminjaman.tanggal_pinjam',
                'datapeminjaman.status',
            )
            ->leftJoin('users', 'datapeminjaman.peminjam_id', '=', 'users.id')
            ->leftJoin('jenisbarang', 'datapeminjaman.jenis_barang_id', '=', 'jenisbarang.id')
            ->leftJoin('databarang', 'datapeminjaman.barang_id', '=', 'databarang.id');

        if (!$user->hasRole('super-admin')) {
            $query->where('users.name', '=', $user->name);
        }
        if ($request->has('databarang')) {
            $query->whereIn('datapeminjaman.barang_id', $request->databarang);
        }

        if ($request->has('jenisbarang')) {
            $query->whereIn('datapeminjaman.jenis_barang_id', $request->jenisbarang);
        }

        if ($request->has('users')) {
            $query->whereIn('datapeminjaman.peminjam_id', $request->users);
        }
        $dataPeminjaman = $query->get();
        $pdf = PDF::loadView('master-table.data-peminjaman.print', with(['dataPeminjaman' => $dataPeminjaman, 'users' => $user]));
        return $pdf->stream('data-peminjaman.pdf');
    }


    public function show(DataPeminjaman $dataPeminjaman)
    {
        return view('master-table.data-peminjaman.show', compact('dataPeminjaman'));
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
            $dataBarang = $dataPeminjaman->dataBarang;
            $tersedia = $dataBarang->tersedia + $dataPeminjaman->quantity;
            if ($tersedia > $dataBarang->quantity) {
                return redirect()->back()->with('error', 'Stok barang melebihi jumlah yang tersedia');
            }
            $dataBarang->tersedia = $tersedia;
            $dataBarang->save();
            $dataPeminjaman->status = $request->status;
            $dataPeminjaman->save();
        } elseif ($request->status === 'Sedang Dipinjam') {
            $dataBarang = $dataPeminjaman->dataBarang;
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
