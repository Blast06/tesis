<?php

namespace App\Http\Requests;

use App\{Article, Website};
use Illuminate\Foundation\Http\FormRequest;
use App\Notifications\NewArticleNotification;

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
            'file' => 'nullable|image:jpeg,png,gif,svg|max:5120'
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

    /**
     * @param \App\Website $website
     * @return mixed
     */
    public function createArticle(Website $website)
    {
        return tap($website->articles()->create($this->validated()), function ($article) {
            $this->uploadImage($article);
            $this->usersNotificationToArticle($article);
        });
    }

    /**
     * @param \App\Article $article
     */
    private function uploadImage(Article $article)
    {
        if($this->hasFile('file')) {
            $article->addMedia(request()->file)->toMediaCollection('articles');
        }
    }

    /**
     * @param \App\Article $article
     */
    private function usersNotificationToArticle(Article $article)
    {
        foreach ($this->getUsersSubscribe($article) as $user) {
            $user->notify(new NewArticleNotification($user, $article));
        }
    }

    /**
     * @param \App\Article $article
     * @return mixed
     */
    private function getUsersSubscribe(Article $article)
    {
        return $article->website->subscribedUsers()
            ->where('id', '<>', $article->website->user_id)
            ->get();
    }

}
