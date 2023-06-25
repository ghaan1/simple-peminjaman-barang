<?php

namespace App\Http\Controllers\MasterTable;

use App\Models\DataPeminjaman;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataPeminjamanRequest;
use App\Http\Requests\UpdateDataPeminjamanRequest;
use App\Models\DataBarang;
use App\Models\JenisBarang;
use App\Models\ProfileUser;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Request as GlobalRequest;

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

        $query = DB::table('datapeminjaman')
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
                'datapeminjaman.ktp_peminjam',
            )
            ->leftJoin('users', 'datapeminjaman.peminjam_id', '=', 'users.id')
            ->leftJoin('jenisbarang', 'datapeminjaman.jenis_barang_id', '=', 'jenisbarang.id')
            ->leftJoin('databarang', 'datapeminjaman.barang_id', '=', 'databarang.id');

        if ($user->hasRole('admin-rt')) {
            $query->when($request->input('databarang'), function ($query, $databarang) {
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
                ->when($request->input('tanggal'), function ($query, $tanggal) {
                    return $query->whereDate('datapeminjaman.tanggal_pinjam', $tanggal);
                })
                ->orderBy('datapeminjaman.tanggal_pinjam', 'DESC');
        } else {
            $query->where('users.name', '=', $user->name)
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
                ->when($request->input('tanggal'), function ($query, $tanggal) {
                    return $query->whereDate('datapeminjaman.tanggal_pinjam', $tanggal);
                })
                ->orderBy('datapeminjaman.tanggal_pinjam', 'DESC');
        }

        $dataPeminjaman = $query->paginate(5);
        $dataBarangSelected = $request->input('databarang');
        $jenisBarangSelected = $request->input('jenisbarang');
        $userSelected = $request->input('users');
        $statusSelected = $request->input('status');
        $tanggalSelected = $request->input('tanggal');
        $request->session()->put('tanggal', $tanggalSelected);

        return view('master-table.data-peminjaman.index')->with([
            'nama_barang' => $nama_barang,
            'statusSelected' => $statusSelected,
            'status' => $status,
            'userSelected' => $userSelected,
            'jenisBarangSelected' => $jenisBarangSelected,
            'dataBarangSelected' => $dataBarangSelected,
            'tanggalSelected' => $tanggalSelected,
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
        $ktp = ProfileUser::all();
        return view('master-table.data-peminjaman.create')->with([
            'dataBarang' => $dataBarang,
            'jenisBarang' => $jenisBarang,
            'user' => $user,
            'ktp' => $ktp,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjam_id' => 'required',
            'jenis_barang_id' => 'required',
            'barang_id' => 'required',
            'quantity' => 'required|regex:/^[0-9]*$/|max:5',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required',
            'ktp_peminjam' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'peminjam_id.required' => 'Nama Peminjam Wajib Diisi',
            'jenis_barang_id.required' => 'Jenis Barang Wajib Diisi',
            'barang_id.required' => 'Nama Barang Wajib Diisi',
            'quantity.required' => 'Quantity Wajib Diisi',
            'quantity.regex' => 'Quantity Wajib Angka',
            'quantity.max' => 'Quantity Maksimal 5 Digit',
            'tanggal_pinjam.required' => 'Tanggal Wajib Diisi',
            'tanggal_pinjam.date' => 'Tanggal Wajib Diluar Format',
            'status.required' => 'Status Wajib Diisi',
            'ktp_peminjam.image' => 'KTP Tidak Sesuai Format',
            'ktp_peminjam.mimes' => 'KTP Hanya Mendukung Format jpeg, png, jpg',
            'ktp_peminjam.max' => 'Ukuran KTP Terlalu Besar',
        ]);

        $dataBarang = DataBarang::findOrFail($request['barang_id']);
        if ($request['quantity'] > $dataBarang->tersedia) {
            return redirect()->route('data-peminjaman.create')
                ->withInput()
                ->withErrors(['quantity' => 'Quantity melebihi stok yang tersedia']);
        }

        // Proses foto yang diunggah
        if ($request->hasFile('ktp_peminjam')) {
            $ktp = $request->file('ktp_peminjam');
            $validExtensions = ['jpg', 'jpeg', 'png'];
            if (!in_array(strtolower($ktp->getClientOriginalExtension()), $validExtensions)) {
                return redirect()->route('data-peminjaman.create')
                    ->withInput()
                    ->withErrors(['ktp_peminjam' => 'KTP harus berupa file dengan format jpeg, png, atau jpg']);
            }

            $namaKtp = uniqid() . '.' . $ktp->getClientOriginalExtension();
            $ktp->storeAs('public/ktp-peminjaman', $namaKtp);
            // dd($ktp);

            $dataPeminjaman = DataPeminjaman::create([
                'peminjam_id' => $request['peminjam_id'],
                'jenis_barang_id' => $request['jenis_barang_id'],
                'barang_id' => $request['barang_id'],
                'quantity' => $request['quantity'],
                'tanggal_pinjam' => $request['tanggal_pinjam'],
                'ktp_peminjam' => 'ktp-peminjaman/' . $namaKtp, // Simpan nama ktp ke dalam kolom 'ktp'
            ]);
        } elseif ($request->show_ktp === 'on') {
            $ktpLama = ProfileUser::where('user_id', $request['peminjam_id'])->first();
            $fotoKtpLAMA = $ktpLama->ktp;
            $dataPeminjaman = DataPeminjaman::create([
                'peminjam_id' => $request['peminjam_id'],
                'jenis_barang_id' => $request['jenis_barang_id'],
                'barang_id' => $request['barang_id'],
                'quantity' => $request['quantity'],
                'tanggal_pinjam' => $request['tanggal_pinjam'],
                'ktp_peminjam' => $fotoKtpLAMA,
            ]);
        } else {
            return redirect()->route('data-peminjaman.create')
                ->withInput()
                ->with(['ktp_review' => 'KTP Harus Ada']);
        }

        $tersedia = $dataBarang->tersedia - $request['quantity'];
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
        $tanggal = $request->session()->get('tanggal');
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

        if ($request->has('databarang')) {
            $query->whereIn('datapeminjaman.barang_id', $request->databarang);
        }

        if ($request->has('jenisbarang')) {
            $query->whereIn('datapeminjaman.jenis_barang_id', $request->jenisbarang);
        }

        if ($request->has('users')) {
            $query->whereIn('datapeminjaman.peminjam_id', $request->users);
        }

        if ($tanggal) {
            $query->whereDate('datapeminjaman.tanggal_pinjam', $tanggal);
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
