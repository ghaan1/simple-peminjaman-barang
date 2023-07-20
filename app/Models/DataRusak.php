<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRusak extends Model
{
use HasFactory;
    protected $table = 'data_rusaks';
    protected $fillable = [
        'user_id', 'barang_id', 'quantity_rusak','quantity_perbaikan', 'status_rusak'
    ];

    public function databarang()
    {
        return $this->belongsTo(DataBarang::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function perbaikan()
    {
        return $this->hasOne(DataPerbaikan::class, 'rusak_id');
    }
}
