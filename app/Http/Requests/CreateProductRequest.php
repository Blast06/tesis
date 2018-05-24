<?php

namespace App\Http\Requests;

use App\Product;
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
            'price' => 'required|numeric|digits_between:3,9',
            'stock' => 'nullable|numeric|digits_between:1,4',
            'sub_category_id' => 'required|numeric',
            'status' => 'required|in:' .Product::STATUS_AVAILABLE. ',' .Product::STATUS_NOT_AVAILABLE. ',' .Product::STATUS_PRIVATE,
            'description' => 'required|min:20',
            'file.*' => 'required|image:jpeg,png,gif,svg|max:5120'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'titulo',
            'price' => 'precio',
            'stock' => 'cantidad',
            'sub_category_id' => 'categoria',
            'status' => 'estado',
            'description' => 'descripcion'
        ];
    }

    public function createProduct(Website $website)
    {
        return tap($website->products()->create($this->validated()), function ($product) {
            $this->uploadImage($product);
        });
    }

    private function uploadImage(Product $product)
    {
        if($this->hasFile('file')) {
            foreach (request()->file as $file) {
                $product->addMedia($file)->toMediaCollection('products');
            }
        }
    }

}
