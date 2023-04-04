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
            'kode_jb' => 'required|max:3|unique:jenisbarang|regex:/^[\pL\s\d]+$/u',
            'jenis_barang' => 'required|min:3|max:100|unique:jenisbarang|regex:/^[\pL\s\d]+$/u',
        ];
    }

    public function messages()
    {
        return [
            'kode_jb.required' => 'Kode Jenis barang Wajib Diisi',
            'jenis_barang.required' => 'Jenis Barang Wajib Diisi',
            'kode_jb.regex' => 'Kode Jenis barang tidak boleh karakter @!_?',
            'kode_jb.unique' => 'Kode Jenis Barang Sudah Ada',
            'jenis_barang.unique' => 'Jenis Barang Sudah Ada',
            'jenis_barang.min' => 'Jenis Barang Minimal 3 karakter ',
            'jenis_barang.regex' => 'Jenis Barang tidak boleh karakter @!_?',
            'jenis_barang.max' => 'Jenis Barang Maksimal 100 karakter ',
            'kode_jb.max' => 'Kode Jenis barang Maksimal 3 karakter',
        ];
    }
}

