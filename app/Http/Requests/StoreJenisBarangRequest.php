<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJenisBarangRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kode_jb' => 'required|max:3|unique:jenisbarang',
            'jenis_barang' => 'required|min:3|max:100|unique:jenisbarang',
        ];
    }

    public function messages()
    {
        return [
            'kode_jb.required' => 'Kode Jenis barang Wajib Diisi',
            'jenis_barang.required' => 'Jenis Barang Wajib Diisi',
            'kode_jb.unique' => 'Kode Jenis Barang Sudah Ada',
            'jenis_barang.unique' => 'Jenis Barang Sudah Ada',
            'jenis_barang.min' => 'Jenis Barang Minimal 3 karakter ',
            'jenis_barang.max' => 'Jenis Barang Maksimal 100 karakter ',
            'kode_jb.max' => 'Kode Jenis barang Maksimal 3 karakter',
        ];
    }
}

