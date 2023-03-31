<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;
    protected $table = 'jenisbarang';
    protected $fillable = ['jenis_barang'];

    public function databarang()
    {
        return $this->belongsTo(DataBarang::class);
    }

}
