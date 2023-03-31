<?php

namespace Database\Seeders;

use App\Models\DataBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataBarang::insert(
            [
            [
                'admin_id' => 'SuperAdmin',
                'nama_barang' => 'Televison',
                'jenis_barang' => 'ElekTronik',
                'harga_barang' => '1000000000',
                'quantity' => '50',
                'tersedia' => '100',
            ],
            [
                'admin_id' => 'SuperAdmin',
                'nama_barang' => 'Anime',
                'jenis_barang' => 'Figure',
                'harga_barang' => '1000000000',
                'quantity' => '50',
                'tersedia' => '100',
            ],
            [
                'admin_id' => 'SuperAdmin',
                'nama_barang' => 'Laptop',
                'jenis_barang' => 'ElekTronik',
                'harga_barang' => '1000000000',
                'quantity' => '50',
                'tersedia' => '100',
            ],
            [
                'admin_id' => 'SuperAdmin',
                'nama_barang' => 'HandPhone',
                'jenis_barang' => 'ElekTronik',
                'harga_barang' => '1000000000',
                'quantity' => '50',
                'tersedia' => '100',
            ],
            [
                'admin_id' => 'SuperAdmin',
                'nama_barang' => 'Buku Pedoman',
                'jenis_barang' => 'Buku',
                'harga_barang' => '1000000000',
                'quantity' => '50',
                'tersedia' => '100',
            ],
            [
                'admin_id' => 'SuperAdmin',
                'nama_barang' => 'Game Tekken 8',
                'jenis_barang' => 'Elektronik',
                'harga_barang' => '1000000000',
                'quantity' => '50',
                'tersedia' => '100',
            ],
            [
                'admin_id' => 'SuperAdmin',
                'nama_barang' => 'Lotong Sayur',
                'jenis_barang' => 'Makanan Frozen',
                'harga_barang' => '1000000000',
                'quantity' => '50',
                'tersedia' => '100',
            ],
            ]
        );
    }
}
