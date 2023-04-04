<?php

namespace Database\Seeders;

use App\Models\DataBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataBarangSeeder extends Seeder
{

    public function run()
    {
        DataBarang::insert(
            [
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Televison',
                    'kode_jbs' => 'EK-1',
                    'jenis_barang_id' => '1',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 30,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Anime',
                    'kode_jbs' => 'EK-2',
                    'jenis_barang_id' => '1',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 20,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Buku Matematika',
                    'kode_jbs' => 'BK-1',
                    'jenis_barang_id' => '3',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 29,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'HandPhone',
                    'kode_jbs' => 'EK-3',
                    'jenis_barang_id' => '1',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 49,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Buku Pedoman',
                    'kode_jbs' => 'BK-2',
                    'jenis_barang_id' => '3',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 50,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Game Tekken 8',
                    'kode_jbs' => 'EK-4',
                    'jenis_barang_id' => '1',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 50,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Lotong Sayur',
                    'kode_jbs' => 'MA-1',
                    'jenis_barang_id' => '6',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 50,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Lotong Balap',
                    'kode_jbs' => 'MA-2',
                    'jenis_barang_id' => '6',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 50,
                ],
            ]
        );
    }
}
