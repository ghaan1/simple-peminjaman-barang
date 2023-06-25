<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::Select(
            'users.name',
            'users.email',
            'profile_users.nik',
            'profile_users.tanggal_lahir',
            'profile_users.alamat',
            'profile_users.jenis_kelamin',
            'profile_users.no_hp'
        )
            ->leftJoin('profile_users', 'users.id', '=', 'profile_users.user_id')
            ->get();
    }
    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'NIK',
            'Tanggal Lahir',
            'Alamat',
            'Jenis Kelamin',
            'No HP',
        ];
    }
}
