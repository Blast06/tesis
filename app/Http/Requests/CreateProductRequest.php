<?php

namespace App\Http\Requests;

use App\Website;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => 'required',
            'price' => 'required',
            'sub_category_id' => 'required',
            'description' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name' => 'titulo',
            'price' => 'precio',
            'sub_category_id' => 'categoria',
            'description' => 'descripcion'
        ];
    }

    public function createProduct(Website $website)
    {
        return [
            'data' => $website->products()->create($this->validated())
        ];
    }
}
