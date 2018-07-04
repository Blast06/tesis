<?php

namespace App\Http\Requests;

use App\Article;
use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasNotRating($this->article);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating' => 'required|numeric',
            'comment' => 'nullable|present|min:5',
            'user_id' => ''
        ];
    }

    public function createReview(Article $article)
    {
        $campos = $this->validated();
        $campos['user_id'] = auth()->id();
        return $article->reviews()->create($campos);
    }
}
