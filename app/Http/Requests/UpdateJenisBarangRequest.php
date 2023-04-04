<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UpdateJenisBarangRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $jenisbarang = $this->route('jenisbarang');
        $id = null;
        if ($jenisbarang) {
            $id = $jenisbarang->id;
        }

        $rules = [
            'kode_jb' => 'required|max:3|regex:/^[\pL\s\d]+$/u',
            'jenis_barang' => 'required|min:3|max:100|regex:/^[\pL\s\d]+$/u',
        ];

        if ($this->getMethod() == 'PATCH') {
            $rules['kode_jb'] .= '|unique:jenisbarang,kode_jb,' . $id;
            $rules['jenis_barang'] .= '|unique:jenisbarang,jenis_barang,' . $id;

            $validator = Validator::make($this->all(), $rules);
            $validator->sometimes('kode_jb', 'unique:jenisbarang,kode_jb,' . $id, function ($input) use ($jenisbarang) {
                return $input->kode_jb != $jenisbarang->kode_jb;
            });
            $validator->sometimes('jenis_barang', 'unique:jenisbarang,jenis_barang,' . $id, function ($input) use ($jenisbarang) {
                return $input->jenis_barang != $jenisbarang->jenis_barang;
            });

            $this->setValidator($validator);
        }

        return $rules;
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
