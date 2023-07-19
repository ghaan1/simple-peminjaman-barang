<?php

namespace App\Http\Controllers\PerbaikanRusak;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataPerbaikanRequest;
use App\Http\Requests\UpdateDataPerbaikanRequest;
use App\Models\DataBarang;
use App\Models\DataPerbaikan;
use App\Models\DataRusak;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class DataPerbaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $nama_barang = $request->input('nama_barang');
        $dataPerbaikan = DB::table('data_perbaikans')->select(
            'data_perbaikans.id',
            'data_perbaikans.tanggal_perbaikan',
            'data_perbaikans.rusak_id',
            'data_perbaikans.bukti_perbaikan',
            'data_perbaikans.ktp_perbaikan',
            'data_rusaks.user_id',
            'users.name',
            'data_rusaks.barang_id',
            'data_rusaks.quantity_rusak',
            'data_rusaks.status_rusak',
            'databarang.nama_barang',
        )
            ->join('data_rusaks', 'data_perbaikans.rusak_id', '=', 'data_rusaks.id')
            ->join('databarang', 'data_rusaks.barang_id', '=', 'databarang.id')
            ->join('users', 'data_rusaks.user_id', '=', 'users.id')
            ->when($request->input('nama_barang'), function ($query, $nama_barang) {
                return $query->where('nama_barang', 'like', '%' . $nama_barang . '%');
            })
            ->when($request->input('tanggal'), function ($query, $tanggal) {
                return $query->whereDate('data_perbaikans.tanggal_perbaikan', $tanggal);
            })
            ->paginate(5);
        $tanggalSelected = $request->input('tanggal');
        $request->session()->put('tanggal', $tanggalSelected);
        return view('rusak-perbaikan.perbaikan.index')->with([
            'dataPerbaikan' => $dataPerbaikan,
            'tanggalSelected' => $tanggalSelected,
            'nama_barang' => $nama_barang,
        ]);
    }

    public function show(DataPerbaikan $dataPerbaikan)
    {
        //
    }

    public function edit(DataPerbaikan $perbaikan)
    {
        $dataRusak = DataRusak::where('id', $perbaikan->rusak_id)->first();
        $dataBarang = DataBarang::all();
        $users = User::all();


        return view('rusak-perbaikan.perbaikan.edit')->with([
            'perbaikan' => $perbaikan,
            'dataRusak' => $dataRusak,
            'dataBarang' => $dataBarang,
            'users' => $users,
        ]);
    }



    public function update(Request $request, DataPerbaikan $perbaikan)
    {
        $dataPerbaikan = DataPerbaikan::findOrFail($perbaikan->id);
        $dataRusak = DataRusak::findOrFail($dataPerbaikan->rusak_id);
        $dataBarang = DataBarang::findOrFail($dataRusak->barang_id);

        // Validasi input form
        $request->validate(
            [
                'tanggal_perbaikan' => 'required',
                'status_rusak' => 'required',
                'bukti_perbaikan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'ktp_perbaikan' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'quantity_rusak' => 'required|numeric|min:1',
                'quantity_perbaikan' => 'required|numeric|max:' . $request->quantity_rusak,
            ],
            [
                'tanggal_perbaikan.required' => 'Tanggal Perbaikan Wajib Diisi',
                'status_rusak.required' => 'Status Barang Wajib Diisi',
                'bukti_perbaikan.required' => 'Bukti Perbaikan Wajib Diisi',
                'bukti_perbaikan.image' => 'Bukti Perbaikan Tidak Sesuai Format',
                'bukti_perbaikan.mimes' => 'Bukti Perbaikan Hanya Mendukung Format jpeg, png, jpg',
                'bukti_perbaikan.max' => 'Ukuran Bukti Perbaikan Terlalu Besar',
                'ktp_perbaikan.required' => 'Ktp Perbaikan Wajib Diisi',
                'ktp_perbaikan.image' => 'Ktp Perbaikan Tidak Sesuai Format',
                'ktp_perbaikan.mimes' => 'Ktp Perbaikan Hanya Mendukung Format jpeg, png, jpg',
                'ktp_perbaikan.max' => 'Ukuran Ktp Perbaikan Terlalu Besar',
                'quantity_rusak.required' => 'Quantity Wajib Diisi',
                'quantity_perbaikan.max' => 'Jumlah perbaikan tidak bisa lebih dari jumlah kerusakan',
                'quantity.numeric' => 'Quantity Wajib Angka',
                'quantity.min' => 'Quantity minimal 1 Digit',
            ]
        );

        // Update data perbaikan
        $dataPerbaikan->tanggal_perbaikan = $request->tanggal_perbaikan;
        $dataRusak->status_rusak = $request->status_rusak;

       
        if ($request->quantity_perbaikan) {
           
            $remaining_rusak = $dataRusak->quantity_rusak - $request->quantity_perbaikan;
        
            
            $dataRusak->quantity_rusak = $remaining_rusak;
            $dataRusak->save();

            $dataBarang->tersedia += $request->quantity_perbaikan;
            $dataBarang->save();
        }

        //  // Cek perubahan nilai quantity_rusak
        //  if ($request->quantity_rusak) {
        //     // Hitung selisih quantity
        //     // $selisihQuantity = $request->quantity_rusak - $dataRusak->quantity_rusak;

        //     // Update nilai quantity_rusak pada $dataRusak
        //     $quantityPerbaikan = $request->quantity_rusak;

        //     // Tambahkan selisih quantity ke $dataBarang->tersediaan
        //     $dataBarang->tersedia += $quantityPerbaikan;
        //     $dataBarang->save();
        // }

        // Simpan foto bukti perbaikan
        if ($request->hasFile('bukti_perbaikan')) {
            $bukti = $request->file('bukti_perbaikan');
            $validExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = strtolower($bukti->getClientOriginalExtension());

            if (!in_array($fileExtension, $validExtensions)) {
                return redirect()->route('data-peminjaman.create')
                    ->withInput()
                    ->withErrors(['bukti_perbaikan' => 'Bukti harus berupa file dengan format jpeg, png, atau jpg']);
            }

            $namaBukti = uniqid() . '.' . $fileExtension;
            $bukti->storeAs('public/database/bukti', $namaBukti);

            $dataPerbaikan->bukti_perbaikan = 'database/bukti/' . $namaBukti;
        }

        // Simpan foto KTP perbaikan
        if ($request->hasFile('ktp_perbaikan')) {
            $ktpPerbaikan = $request->file('ktp_perbaikan');
            $validExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = strtolower($ktpPerbaikan->getClientOriginalExtension());

            if (!in_array($fileExtension, $validExtensions)) {
                return redirect()->route('data-peminjaman.create')
                    ->withInput()
                    ->withErrors(['ktp_perbaikan' => 'KTP harus berupa file dengan format jpeg, png, atau jpg']);
            }

            $namaKtpPerbaikan = uniqid() . '.' . $fileExtension;
            $ktpPerbaikan->storeAs('public/database/bukti', $namaKtpPerbaikan);

            $dataPerbaikan->ktp_perbaikan = 'database/bukti/' . $namaKtpPerbaikan;
        }

        // Simpan data perbaikan
        $dataPerbaikan->save();

        // Redirect atau berikan respon sesuai kebutuhan
        return redirect()->route('perbaikan.index')->with('success', 'Perbaikan berhasil diupdate');
    }

    public function print(Request $request)
    {
        $tanggal = $request->session()->get('tanggal');
        $user = Auth::user();
        $query = DB::table('data_perbaikans')
            ->select(
                'data_perbaikans.id',
                'data_perbaikans.tanggal_perbaikan',
                'data_perbaikans.rusak_id',
                'data_perbaikans.bukti_perbaikan',
                'data_perbaikans.ktp_perbaikan',
                'data_rusaks.user_id',
                'users.name',
                'data_rusaks.barang_id',
                'data_rusaks.quantity_rusak',
                'data_rusaks.status_rusak',
                'databarang.nama_barang',
            )
            ->join('data_rusaks', 'data_perbaikans.rusak_id', '=', 'data_rusaks.id')
            ->join('databarang', 'data_rusaks.barang_id', '=', 'databarang.id')
            ->join('users', 'data_rusaks.user_id', '=', 'users.id');

        if ($tanggal) {
            $query->whereDate('data_perbaikans.tanggal_perbaikan', $tanggal);
        }

        $dataPerbaikan = $query->get();
        if ($dataPerbaikan) {
            $pdf = PDF::loadView('rusak-perbaikan.perbaikan.print', with(['dataPerbaikan' => $dataPerbaikan, 'users' => $user]));
            return $pdf->download('perbaikan.pdf');
        } else {
            return redirect()->back()->with('error', 'Data perbaikan tidak tersedia.');
        }

        return $pdf->stream('perbaikan.pdf');
    }



    public function destroy(DataPerbaikan $perbaikan)
    {
        $rusak = DataRusak::findOrFail($perbaikan->rusak_id);
        if ($rusak->status_rusak === 'rusak') {
            return redirect()->route('perbaikan.index')
                ->with('error', 'Tidak Dapat Menghapus Data Barang Perbaikan Yang Masih Berstatus Rusak');
        }

        try {
            $perbaikan->delete();
            return redirect()->route('perbaikan.index')
                ->with('success', 'Hapus Data Barang Perbaikan Sukses');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1451) {
                return redirect()->route('perbaikan.index')
                    ->with('error', 'Tidak Dapat Menghapus Data Barang Perbaikan Yang Masih Digunakan Oleh Kolom Lain');
            } else {
                return redirect()->route('perbaikan.index')
                    ->with('error', 'Gagal menghapus data barang Perbaikan');
            }
        }
    }
}
