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
                'jenis_barang' => 'Elektronik',

            ],
            [
                'jenis_barang' => 'Figure',

            ],
            [
                'jenis_barang' => 'Buku',

            ],
            [
               'jenis_barang' => 'Helm',

            ],
            [
                'jenis_barang' => 'Minuman',

            ],
            [

                'jenis_barang' => 'Makanan',

            ],
            [


                'jenis_barang' => 'Satset',

            ],
            ]
        );
    }
}
