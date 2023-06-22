<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMenuItemRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|' . Rule::unique('menu_items')->ignore($this->menu_item),
            'route' => 'required|' . Rule::unique('menu_items')->ignore($this->menu_item),
            'permission_name' => 'required',
            'menu_group_id' => 'required|exists:menu_groups,id'
        ];
    }
}
