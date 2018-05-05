<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class CreateWebsiteRequest extends FormRequest
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

    /**4
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:40|unique:websites',
            'phone' => 'required|min:17|max:17',
            'address' => 'required|min:10|max:255'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'sitio',
            'phone' => 'telefono',
            'address' => 'direccion'
        ];
    }
}
