<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJenisBarangRequest extends FormRequest
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
            'jenis_barang' => 'required|min:3|max:100',
        ];
    }

    public function messages()
    {
        return [
            'jenis_barang.required' => 'Jenis Barang Wajib Diisi',
            'jenis_barang.min' => 'Jenis Barang Minimal 3 ',
            'jenis_barang.max' => 'Jenis Barang Minimal 100 ',
        ];
    }
    }

