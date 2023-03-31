<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'admin_id' => 'required',
            'nama_barang' => 'required|min:3|max:100',
            'jenis_barang_id' => 'required',
            'harga_barang' => 'required|min:3|regex:/^[0-9]*$/|max:100',
            'quantity' => 'required|regex:/^[0-9]*$/',
            'tersedia' => 'required|regex:/^[0-9]*$/',
        ];
    }

    public function messages()
    {
        return [
            'admin_id.required' => 'Admin Wajib Diisi',
            'nama_barang.required' => 'Nama Barang Wajib Diisi',
            'nama_barang.min' => 'Nama Barang Minimal 3 ',
            'nama_barang.max' => 'Nama Barang Maxsimal 100 ',
            'jenis_barang_id.required' => 'Jenis Barang Wajib Diisi',
            'harga_barang.required' => 'Harga Barang Wajib Diisi',
            'harga_barang.min' => 'Harga Barang Minimal 3 ',
            'harga_barang.max' => 'Harga Barang Minimal 100 ',
            'harga_barang.regex' => 'Harga Barang Wajib Angka ',
            'quantity.required' => 'Quantity Wajib Diisi',
            'tersedia.required' => 'tersedia Wajib Diisi',
            'quantity.regex' => 'Quantity Wajib Angka',
            'tersedia.regex' => 'tersedia Wajib Angka',
        ];
    }

}
