<?php

namespace App\Http\Requests;

use App\Website;
use Illuminate\Foundation\Http\FormRequest;

class UploadImageArticleRequest extends FormRequest
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
            'article_id' => 'required',
            'file.*' => 'required|image:jpeg,png,gif,svg|max:5120'
        ];
    }

    public function uploadImage(Website $website)
    {
        return tap($website->articles()->where('id', $this->validated()['article_id'])->firstOrFail(), function ($article) {
            foreach (request()->file as $file) {
                $article->addMedia($file)->toMediaCollection('articles');
            }
        });
    }
}
