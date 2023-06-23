<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRusak extends Model
{
    use HasFactory;
    protected $table = 'data_rusaks';
    protected $fillable = [
        'user_id', 'barang_id', 'quantity_rusak', 'status_rusak'
    ];

    public function databarang()
    {
        return $this->belongsTo(DataBarang::class, 'barang_id');
    }
}
