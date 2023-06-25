<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataRusakRequest extends FormRequest
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
            'role' => 'required',
            'user_id' => 'required',
            'barang_id' => 'required',
            'quantity_rusak' => 'required|regex:/^[0-9]*$/|max:5',
        ];
    }

    public function messages()
    {
        return [
            'role.required' => 'Nama Peran Wajib Diisi',
            'user_id.required' => 'Nama User Wajib Diisi',
            'barang_id.required' => 'Nama Barang Wajib Diisi',
            'quantity_rusak.required' => 'Quantity Wajib Diisi',
            'quantity_rusak.regex' => 'Quantity Wajib Angka',
            'quantity_rusak.max' => 'Quantity Maksimal 5 Digit',
        ];
    }
}
