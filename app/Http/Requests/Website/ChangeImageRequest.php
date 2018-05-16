<?php

namespace App\Http\Requests\Website;

use App\Models\Website;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class ChangeImageRequest extends FormRequest
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
            'image' => 'required|image:jpeg,png,gif,svg|max:5120'
        ];
    }

    public function attributes()
    {
        return [
            'image' => 'imagen del sitio',
        ];
    }

    public function updateImage(Website $website)
    {
        $website->clearMediaCollection('websites');

        $website->addMediaFromRequest('image')->toMediaCollection('websites');
    }
}
