<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    use HasFactory;
    protected $table = 'databarang';
    protected $fillable = ['admin_id', 'nama_barang', 'jenis_barang',
    'harga_barang', 'quantity', 'tersedia'];

    public function peminjaman()
    {
        return $this->belongsTo(DataPeminjaman::class);
    }

}
