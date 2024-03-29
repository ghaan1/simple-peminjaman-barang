<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    use HasFactory;
    protected $table = 'databarang';
    protected $fillable = [
        'admin_id', 'nama_barang', 'kode_jbs', 'jenis_barang_id',
        'harga_barang', 'quantity', 'tersedia'
    ];

    public function admin() 
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
   
    public function jenisbarang()
    {
        return $this->belongsTo(JenisBarang::class);
    }

    public function peminjaman()
    {
        return $this->belongsTo(DataPeminjaman::class);
    }

    public function dataRusaks()
    {
        return $this->hasMany(DataRusak::class, 'barang_id');
    }

    
}
