<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPerbaikan extends Model
{
    use HasFactory;
    protected $table = 'data_perbaikans';
    protected $fillable = [
        'tanggal_perbaikan', 'rusak_id', 'bukti_perbaikan', 'ktp_perbaikan'
    ];

    public function rusak()
    {
        return $this->belongsTo(DataRusak::class, 'rusak_id');
    }
}
