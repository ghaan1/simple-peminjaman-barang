<?php

namespace Database\Seeders;

use App\Models\ProfileUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileUserSeeder extends Seeder
{

    public function run()
    {
        ProfileUser::insert(
            [
                [
                    'nik' => '1',
                    'tanggal_lahir' => '2000-01-01',
                    'alamat' => 'Jl. Jalan1',
                    'jenis_kelamin' => 'L',
                    'no_hp' => '081234567891',
                    'foto' => 'database/profile/default.jpg',
                    'ktp' => 'database/ktp/ktp.jpg',
                    'user_id' => '1'
                ],
                [
                    'nik' => '2',
                    'tanggal_lahir' => '2000-01-02',
                    'alamat' => 'Jl. Jalan2',
                    'jenis_kelamin' => 'P',
                    'no_hp' => '081234567892',
                    'foto' => 'database/profile/default.jpg',
                    'ktp' => 'database/ktp/ktp.jpg',
                    'user_id' => '2'
                ],
                [
                    'nik' => '3',
                    'tanggal_lahir' => '2000-01-03',
                    'alamat' => 'Jl. Jalan3',
                    'jenis_kelamin' => 'L',
                    'no_hp' => '081234567893',
                    'foto' => 'database/profile/default.jpg',
                    'ktp' => 'database/ktp/ktp.jpg',
                    'user_id' => '3'
                ],
                [
                    'nik' => '4',
                    'tanggal_lahir' => '2000-01-04',
                    'alamat' => 'Jl. Jalan4',
                    'jenis_kelamin' => 'P',
                    'no_hp' => '081234567894',
                    'foto' => 'database/profile/default.jpg',
                    'ktp' => 'database/ktp/ktp.jpg',
                    'user_id' => '4'
                ],
            ]
        );
    }
}
