<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\DataPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
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

        $countBarang = DataBarang::count();
        $countPeminjaman = DataPeminjaman::count();
        return view('dashboard.index')
            ->with([
                'countBarang' => $countBarang,
                'countPeminjaman' => $countPeminjaman,
                'chartData' => $chartData,
                'chartData2' => $chartData2,
            ]);
    }
}
