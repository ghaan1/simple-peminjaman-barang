<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UpdateDataBarangRequest extends FormRequest

{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $databarang = $this->route('databarang');
        $id = null;
        if ($databarang) {
            $id = $databarang->id;
        }

        $rules = [
            'admin_id' => 'required',
            'nama_barang' => 'required|min:3|max:100|regex:/^[\pL\s\d]+$/u',
            'jenis_barang_id' => 'required',
            'harga_barang' => 'required|min:3|regex:/^[\pL\s\d]+$/u|max:100',
            'quantity' => 'required|regex:/^[\pL\s\d]+$/u',
            'tersedia' => 'required|regex:/^[\pL\s\d]+$/u',
        ];

        if ($this->getMethod() == 'PATCH') {
            $rules['nama_barang'] .= '|unique:databarang,nama_barang,' . $id;

            $validator = Validator::make($this->all(), $rules);
            $validator->sometimes('nama_barang', 'unique:databarang,nama_barang,' . $id, function ($input) use ($databarang) {
                return $input->nama_barang != $databarang->nama_barang;
            });

            $validator->sometimes('quantity', 'required', function ($input) {
                return $input->quantity > $input->tersedia;
            });

            $this->setValidator($validator);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'admin_id.required' => 'Admin Wajib Diisi',
            'nama_barang.required' => 'Nama Barang Wajib Diisi',
            'nama_barang.min' => 'Nama Barang Minimal 3 ',
            'nama_barang.max' => 'Nama Barang Maksimal 100 ',
            'nama_barang.regex' => 'Nama Barang gak boleh karakter !@?/',
            'jenis_barang_id.required' => 'Jenis Barang Wajib Diisi',
            'harga_barang.required' => 'Harga Barang Wajib Diisi',
            'harga_barang.min' => 'Harga Barang Minimal 3 ',
            'harga_barang.max' => 'Harga Barang Maksimal 100 ',
            'harga_barang.regex' => 'Harga Barang Wajib Angka ',
            'quantity.required' => 'Quantity Wajib Diisi',
            'tersedia.required' => 'tersedia Wajib Diisi',
            'quantity.regex' => 'Quantity Wajib Angka',
            'tersedia.regex' => 'tersedia Wajib Angka',
        ];
    }

}
