<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileUserController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'nik' => 'nullable|regex:/^[0-9]*$/',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_hp' => 'nullable|regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,8}$/',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nik.regex' => 'NIK Tidak Sesuai Format',
            'tanggal_lahir.date' => 'Tanggal Lahir Tidak Sesuai Format',
            'alamat.max' => 'Alamat Melebihi Batas Maksimal',
            'jenis_kelamin.in' => 'Jenis Kelamin Hanya Pada Pilihan L/P',
            'no_hp.regex' => 'Nomer Hp Tidak Sesuai Format',
            'foto.image' => 'Foto Tidak Sesuai Format',
            'foto.mimes' => 'Foto Hanya Support Format jpeg,png,jpg',
            'foto.max' => 'Ukuran Foto Terlalu Besar',
        ]);



        $fotoLama = DB::table('profile_users')->where('user_id', Auth::user()->id)->first();
        $user = $request->user();
        $user->profile()->update($request->except('_token', '_method', 'foto', 'show_foto'));

        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $validExtensions = ['jpg', 'jpeg', 'png'];

            if (!in_array(strtolower($photo->getClientOriginalExtension()), $validExtensions)) {
                return response()->json(['message' => 'The gambar must be a file of type: jpeg, png, jpg.'], 422);
            }
            $oriName = $photo->getClientOriginalName();

            $namaGambar = uniqid() . '.' . $oriName;
            Storage::putFileAs('public/database/profile/', $photo, $namaGambar);
            $user->profile->foto = 'database/profile/' . $namaGambar;
            $user->profile->save();
        } else {
            $user->profile->foto = $fotoLama->foto;
            $user->profile->save();
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
