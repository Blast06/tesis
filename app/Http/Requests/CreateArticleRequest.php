<?php

namespace App\Http\Requests;

use App\Article;
use App\Website;
use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
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
            'status' => 'required|in:' .Article::STATUS_AVAILABLE. ',' .Article::STATUS_NOT_AVAILABLE. ',' .Article::STATUS_PRIVATE,
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
        return tap($website->articles()->create($this->validated()), function ($article) {
            $this->uploadImage($article);
        });
    }

    private function uploadImage(Article $article)
    {
        if($this->hasFile('file')) {
            foreach (request()->file as $file) {
                $article->addMedia($file)->toMediaCollection('articles');
            }
        }
    }

}
