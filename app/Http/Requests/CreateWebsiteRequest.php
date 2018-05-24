<?php

namespace App\Http\Requests;

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
            'name' => 'required|min:4|max:40',
            'username' => 'required|min:4|max:40|unique:websites',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'sitio',
            'username' => 'usuario'
        ];
    }

    /**
     * @return mixed
     */
    public function createWebsite()
    {
        return tap(auth()->user()->websites()->create($this->validated()), function ($website) {
            auth()->user()->subscribeTo($website);
        });
    }
}
