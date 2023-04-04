<?php

namespace Database\Seeders;

use App\Models\JenisBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisBarang::insert(
            [
            [
                'kode_jb' => 'EK',
                'jenis_barang' => 'Elektronik',

            ],
            [
                'kode_jb' => 'FG',
                'jenis_barang' => 'Figure',

            ],
            [
                'kode_jb' => 'BK',
                'jenis_barang' => 'Buku',

            ],
            [
                'kode_jb' => 'HE',
               'jenis_barang' => 'Helm',

            ],
            [
                'kode_jb' => 'MI',
                'jenis_barang' => 'Minuman',

            ],
            [
                'kode_jb' => 'MA',
                'jenis_barang' => 'Makanan',

            ],
            [

                'kode_jb' => 'SAT',
                'jenis_barang' => 'Satset',

            ],
            ]
        );
    }
}
