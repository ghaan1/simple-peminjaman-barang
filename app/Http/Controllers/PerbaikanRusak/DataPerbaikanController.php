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
use Illuminate\Support\Facades\DB;

class DataPerbaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            ->paginate(5);

        return view('rusak-perbaikan.perbaikan.index')->with([
            'dataPerbaikan' => $dataPerbaikan,
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
        $request->validate([
            'tanggal_perbaikan' => 'required',
            'status_rusak' => 'required',
            'bukti_perbaikan' => 'image|mimes:jpeg,png,jpg|max:2048',
            'ktp_perbaikan' => 'image|mimes:jpeg,png,jpg|max:2048',
            'quantity_rusak' => 'required|numeric|min:1',
        ]);

        // Update data perbaikan
        $dataPerbaikan->tanggal_perbaikan = $request->tanggal_perbaikan;
        $dataRusak->status_rusak = $request->status_rusak;

        // Cek perubahan nilai quantity_rusak
        if ($request->quantity_rusak) {
            // Hitung selisih quantity
            // $selisihQuantity = $request->quantity_rusak - $dataRusak->quantity_rusak;

            // Update nilai quantity_rusak pada $dataRusak
            $quantityPerbaikan = $request->quantity_rusak;

            // Tambahkan selisih quantity ke $dataBarang->tersediaan
            $dataBarang->tersedia += $quantityPerbaikan;
            $dataBarang->save();
        }
        $dataRusak->save();

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



    public function destroy(DataPerbaikan $dataPerbaikan)
    {
        //
    }
}
