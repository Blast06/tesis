<?php

namespace App\Http\Requests\Website;

use App\Models\Website;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWebsiteRequest extends FormRequest
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
            'name' => 'required|min:4|max:40',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'sitio',
            'username' => 'usuario'
        ];
    }

    public function updateWebsite(Website $website)
    {
       return $website->update($this->validated());
    }
}
