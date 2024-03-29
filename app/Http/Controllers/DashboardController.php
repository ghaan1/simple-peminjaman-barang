<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\DataPeminjaman;
use App\Models\DataPerbaikan;
use App\Models\DataRusak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $profileUser = \App\Models\ProfileUser::where('user_id', $userId)->first();
        if (!$profileUser) {
            return redirect()->route('profile.edit');
        }
        $chartData = DataBarang::select('databarang.nama_barang', 'databarang.quantity', 'users.name')
            ->leftJoin('users', 'databarang.admin_id', '=', 'users.id')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_barang' => $item->nama_barang,
                    'quantity' => $item->quantity,
                    'name' => $item->name,
                ];
            });

        $chartData2 = DataPeminjaman::select(
            'users.name as user_name',
            DB::raw('COUNT(*) as total_peminjaman')
        )
            ->leftJoin('users', 'datapeminjaman.peminjam_id', '=', 'users.id')
            ->groupBy('users.id', 'users.name')
            ->get();


        $totalBarang = DataBarang::select(
            DB::raw('SUM(quantity) as total_barang')
        )->get();

        $dataRusaks = DataRusak::all();
        $totalRusak = 0;

        foreach ($dataRusaks as $dataRusak) {
            $totalRusak += $dataRusak->quantity_rusak - $dataRusak->quantity_perbaikan;
        }

        $totalPerbaikan = DataRusak::select(
            DB::raw('SUM(quantity_perbaikan) as total_perbaikan')
        )
            ->where('status_rusak', 'diperbaiki',)
            ->get();

        $totalbaik = DataBarang::select(
            DB::raw('SUM(tersedia) as total_baik')
        )
            ->get();



        $peminjamanBarang = DataPeminjaman::where('peminjam_id', $userId)
            ->join('databarang', 'datapeminjaman.barang_id', '=', 'databarang.id')
            ->select('databarang.nama_barang', 'datapeminjaman.quantity')
            ->where('status', '=', 'Sedang Dipinjam')
            ->get();



        // dd($peminjamanBarang);
        $countBarang = DataBarang::count();
        $countPeminjaman = DataPeminjaman::count();
        return view('dashboard.index')
            ->with([
                'countBarang' => $countBarang,
                'countPeminjaman' => $countPeminjaman,
                'chartData' => $chartData,
                'chartData2' => $chartData2,
                'peminjamanBarang' => $peminjamanBarang,
                'totalBarang' => $totalBarang,
                'totalRusak' => $totalRusak,
                'totalPerbaikan' => $totalPerbaikan,
                'totalBaik' => $totalbaik,
            ]);
    }
}
