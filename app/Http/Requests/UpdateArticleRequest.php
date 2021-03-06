<?php

namespace App\Http\Requests;

use App\{Article, Website};
use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
        ];
    }

    /**
     * @return array
     */
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

    public function updateArticle(Article $article)
    {
        return tap($article, function($article) {
            $fields = $this->validated();
            $fields['stock'] = $fields['stock'] === 0 ? null : $fields['stock'];
            $article->update($fields);
        });
    }
}
