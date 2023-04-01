<?php

namespace Database\Seeders;

use App\Models\DataPeminjaman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataPeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataPeminjaman::insert(
            [
                [
                    'peminjam_id' => '2',
                    'jenis_barang_id' => '1',
                    'barang_id' => '1',
                    'quantity' => '50',
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => 'Sedang Dipinjam',
                ],
                [
                    'peminjam_id' => '2',
                    'jenis_barang_id' => '2',
                    'barang_id' => '2',
                    'quantity' => '50',
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => 'Sedang Dipinjam',
                ],
                [
                    'peminjam_id' => '3',
                    'jenis_barang_id' => '3',
                    'barang_id' => '3',
                    'quantity' => '50',
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => 'Sedang Dipinjam',
                ],
                [
                    'peminjam_id' => '4',
                    'jenis_barang_id' => '4',
                    'barang_id' => '4',
                    'quantity' => '50',
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => 'Sedang Dipinjam',
                ],
                [
                    'peminjam_id' => '5',
                    'jenis_barang_id' => '5',
                    'barang_id' => '5',
                    'quantity' => '50',
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => 'Sudah Dikembalikan',
                ],
            ]
        );
    }
}
