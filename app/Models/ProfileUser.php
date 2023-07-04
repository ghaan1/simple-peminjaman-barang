<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Model
{
    use HasFactory;
    protected $table = 'profile_users';
    protected $fillable = [
        'user_id',
        'nik',
        'tanggal_lahir',
        'alamat',
        'jenis_kelamin',
        'no_hp',
        'foto',
        'ktp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
