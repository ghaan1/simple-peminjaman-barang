<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPeminjaman extends Model
{
    use HasFactory;
    protected $table = 'datapeminjaman';
    protected $fillable = [
        'peminjam_id', 'jenis_barang_id', 'barang_id',
        'quantity', 'tanggal_pinjam', 'status'
    ];
}
