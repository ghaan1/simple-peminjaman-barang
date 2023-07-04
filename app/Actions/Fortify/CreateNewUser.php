<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\ProfileUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input)
    {
        $messages = [
            'name.required' => 'Nama Wajib Diisi',
            'name.min' => 'Nama Kurang Dari Ketentuan',
            'name.max' => 'Nama Lebih Dari Dari Ketentuan',
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Email Tidak Sesuai Ketentuan',
            'email.max' => 'Email Lebih Dari Dari Ketentuan',
            'email.unique' => 'Email Telah Ada',
            'password.required' => 'Password Wajib Diisi',
            'password.confirmed' => 'Password Konfirmasi Tidak Sama',
            'nik.required' => 'NIK Wajib Diisi',
            'nik.regex' => 'NIK Tidak Sesuai Format',
            'nik.min' => 'NIK Kurang Dari Ketentuan',
            'tanggal_lahir.required' => 'Tanggal Lahir Wajib Diisi',
            'tanggal_lahir.date' => 'Tanggal Lahir Tidak Sesuai Format',
            'alamat.required' => 'Alamat Wajib Diisi',
            'alamat.max' => 'Alamat Melebihi Batas Maksimal',
            'jenis_kelamin.required' => 'Jenis Kelamin Wajib Diisi',
            'jenis_kelamin.in' => 'Jenis Kelamin Hanya Pada Pilihan L/P',
            'no_hp.required' => 'Nomor Hp Wajib Diisi',
            'no_hp.regex' => 'Nomor Hp Tidak Sesuai Format',
            'foto.required' => 'Foto Wajib Diisi',
            'foto.image' => 'Foto Tidak Sesuai Format',
            'foto.mimes' => 'Foto Hanya Mendukung Format jpeg, png, jpg',
            'foto.max' => 'Ukuran Foto Terlalu Besar',
            'ktp.required' => 'KTP Wajib Diisi',
            'ktp.image' => 'KTP Tidak Sesuai Format',
            'ktp.mimes' => 'KTP Hanya Mendukung Format jpeg, png, jpg',
            'ktp.max' => 'Ukuran KTP Terlalu Besar',
        ];

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'min:4'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'nik' => ['required', 'regex:/^[0-9]*$/', 'min:16'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'no_hp' => ['required', 'regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,8}$/'],
            'foto' => ['required', 'file', 'max:5000', 'mimes:jpg,jpeg,png'],
            'ktp' => ['required', 'file', 'max:5000', 'mimes:jpg,jpeg,png'],
        ], $messages)->validate();


        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'email_verified_at' => now(),
        ]);

        $user->assignRole('warga');

        $fotoPath = null;
        if (isset($input['foto'])) {
            $foto = $input['foto'];
            $validExtensions = ['jpg', 'jpeg', 'png'];
            if (in_array(strtolower($foto->getClientOriginalExtension()), $validExtensions)) {
                $namaGambar = uniqid() . '.' . $foto->getClientOriginalName();
                $fotoPath = $foto->storeAs('public/database/profile', $namaGambar);
            } else {
                // Handle invalid file type...
            }
        }

        // Handle ktp upload...
        $ktpPath = null;
        if (isset($input['ktp'])) {
            $ktp = $input['ktp'];
            $validExtensions = ['jpg', 'jpeg', 'png'];
            if (in_array(strtolower($ktp->getClientOriginalExtension()), $validExtensions)) {
                $namaGambar = uniqid() . '.' . $ktp->getClientOriginalName();
                $ktpPath = $ktp->storeAs('public/database/ktp', $namaGambar);
            } else {
                // Handle invalid file type...
            }
        }

        ProfileUser::create([
            'user_id' => $user->id,
            'nik' => $input['nik'],
            'tanggal_lahir' => $input['tanggal_lahir'],
            'alamat' => $input['alamat'],
            'jenis_kelamin' => $input['jenis_kelamin'],
            'no_hp' => $input['no_hp'],
            'foto' => $fotoPath,
            'ktp' => $ktpPath,
        ]);

        return $user;
    }
}
