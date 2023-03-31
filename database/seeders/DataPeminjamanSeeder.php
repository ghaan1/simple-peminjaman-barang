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
                    'peminjam_id' => 'Televison',
                    'barang_id' => 'ElekTronik',
                    'quantity' => '50',
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => '100',
                ],
                [
                    'peminjam_id' => '2',
                    'peminjam_id' => 'Anime',
                    'barang_id' => 'Figure',
                    'quantity' => '50',
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => '100',
                ],
                [
                    'peminjam_id' => '3',
                    'peminjam_id' => 'Laptop',
                    'barang_id' => 'ElekTronik',
                    'quantity' => '50',
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => '100',
                ],
                [
                    'peminjam_id' => '4',
                    'peminjam_id' => 'HandPhone',
                    'barang_id' => 'ElekTronik',
                    'quantity' => '50',
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => '100',
                ],
                [
                    'peminjam_id' => '5',
                    'peminjam_id' => 'Buku Pedoman',
                    'barang_id' => 'Buku',
                    'quantity' => '50',
                    'tanggal_pinjam' => '2023-03-31',
                    'status' => '100',
                ],
            ]
        );
    }
}
