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
                    'jenis_barang_id' => '1',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 30,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Anime',
                    'jenis_barang_id' => '1',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 20,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Laptop',
                    'jenis_barang_id' => '3',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 29,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'HandPhone',
                    'jenis_barang_id' => '4',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 49,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Buku Pedoman',
                    'jenis_barang_id' => '5',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 50,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Game Tekken 8',
                    'jenis_barang_id' => '6',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 50,
                ],
                [
                    'admin_id' => 1,
                    'nama_barang' => 'Lotong Sayur',
                    'jenis_barang_id' => '7',
                    'harga_barang' => 1000000000,
                    'quantity' => 50,
                    'tersedia' => 50,
                ],
            ]
        );
    }
}
