<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataBarangRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'admin_id' => 'required',
            'nama_barang' => 'required|min:3|max:100|unique:databarang|regex:/^[\pL\s\d]+$/u',
            'jenis_barang_id' => 'required',
            'harga_barang' => 'required|min:3|regex:/^[0-9]*$/|max:100',
            'quantity' => 'required|regex:/^[0-9]*$/|max:5',
            'tersedia' => 'nullable|regex:/^[0-9]*$/',
        ];
    }

    public function messages()
    {
        return [
            'admin_id.required' => 'Admin Wajib Diisi',
            'nama_barang.required' => 'Nama Barang Wajib Diisi',
            'nama_barang.unique' => 'Nama Barang Sudah Ada',
            'nama_barang.min' => 'Nama Barang Minimal 3 ',
            'nama_barang.max' => 'Nama Barang Maksimal 100 ',
            'nama_barang.regex' => 'Nama Barang gak boleh karakter !@?/',
            'jenis_barang_id.required' => 'Jenis Barang Wajib Diisi',
            'harga_barang.required' => 'Harga Barang Wajib Diisi',
            'harga_barang.min' => 'Harga Barang Minimal 3 ',
            'harga_barang.max' => 'Harga Barang Maksimal 100 Digit',
            'harga_barang.regex' => 'Harga Barang Wajib Angka ',
            'quantity.required' => 'Quantity Wajib Diisi',
            'quantity.regex' => 'Quantity Wajib Angka',
            'quantity.max' => 'Quantity Maksimal 5 Digit',
            'tersedia.regex' => 'Tersedia Wajib Angka',
        ];
    }
}
