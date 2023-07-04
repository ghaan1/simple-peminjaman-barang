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
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'nik' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'no_hp' => ['required', 'string', 'max:255'],
            'foto' => ['sometimes', 'file', 'max:5000', 'mimes:jpg,jpeg,png'],
            'ktp' => ['sometimes', 'file', 'max:5000', 'mimes:jpg,jpeg,png'],
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'email_verified_at' => now(),
        ]);

        $user->assignRole('warga');

        // Handle foto upload
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
