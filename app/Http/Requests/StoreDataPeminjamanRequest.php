<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataPeminjamanRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'peminjam_id' => 'required',
            'jenis_barang_id' => 'required',
            'barang_id' => 'required',
            'quantity' => 'required|regex:/^[0-9]*$/|max:5',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'peminjam_id.required' => 'Nama Peminjam Wajib Diisi',
            'jenis_barang_id.required' => 'Jenis Barang Wajib Diisi',
            'barang_id.required' => 'Nama Barang Wajib Diisi',
            'quantity.required' => 'Quantity Wajib Diisi',
            'quantity.regex' => 'Quantity Wajib Angka',
            'quantity.max' => 'Quantity Maksimal 5 Digit',
            'tanggal_pinjam.required' => 'Tanggal Wajib Diisi',
            'tanggal_pinjam.date' => 'Tanggal Wajib Diluar Format',
            'status.required' => 'Status Wajib Diisi',
        ];
    }
}
