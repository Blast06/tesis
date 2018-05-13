<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class ChangeAvatarRequest extends FormRequest
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
            'avatar' => 'required|image:jpeg,png,gif,svg|max:5120'
        ];
    }

    public function updateAvatar()
    {
        auth()->user()->clearMediaCollection('avatars');

        auth()->user()->addMediaFromRequest('avatar')->toMediaCollection('avatars');

        return response()->json(['message' => 'avatar actualizada correctamente.'], Response::HTTP_OK);
    }
}
