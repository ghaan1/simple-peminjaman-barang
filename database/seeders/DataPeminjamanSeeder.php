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
                    'peminjam_id' => 2,
                    'jenis_barang_id' => 1,
                    'barang_id' => 1,
                    'quantity' => 20,
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => 'Sedang Dipinjam',
                    'ktp_peminjam' => 'ktp-peminjaman/ktp_peminjam.jpg',
                    'tanggal_kembali' => '2023-04-01'
                ],
                [
                    'peminjam_id' => 2,
                    'jenis_barang_id' => 1,
                    'barang_id' => 2,
                    'quantity' => 30,
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => 'Sedang Dipinjam',
                    'ktp_peminjam' => 'ktp-peminjaman/ktp_peminjam.jpg',
                    'tanggal_kembali' => '2023-04-01'
                ],
                [
                    'peminjam_id' => 3,
                    'jenis_barang_id' => 3,
                    'barang_id' => 3,
                    'quantity' => 21,
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => 'Sedang Dipinjam',
                    'ktp_peminjam' => 'ktp-peminjaman/ktp_peminjam.jpg',
                    'tanggal_kembali' => '2023-04-01'
                ],
                [
                    'peminjam_id' => 1,
                    'jenis_barang_id' => 1,
                    'barang_id' => 4,
                    'quantity' => 1,
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => 'Sedang Dipinjam',
                    'ktp_peminjam' => 'ktp-peminjaman/ktp_peminjam.jpg',
                    'tanggal_kembali' => '2023-04-01'
                ],
                [
                    'peminjam_id' => 1,
                    'jenis_barang_id' => 3,
                    'barang_id' => 5,
                    'quantity' => 50,
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => 'Sudah Dikembalikan',
                    'ktp_peminjam' => 'ktp-peminjaman/ktp_peminjam.jpg',
                    'tanggal_kembali' => '2023-04-01'
                ],
            ]
        );
    }
}
