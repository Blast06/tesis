<?php

namespace App\Http\Requests;

use App\Rules\validateCurrentPassword;
use Illuminate\Foundation\Http\FormRequest;

class LogoutOtherDevicesRequest extends FormRequest
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
            'password_current' =>  ['required', New validateCurrentPassword()],
        ];
    }

    public function attributes()
    {
        return [
            'password_current' => 'contraseña actual',
        ];
    }

    public function logoutOtherDevices()
    {
        auth()->logoutOtherDevices($this->validated()['password_current']);

        return "las sesiónes activas en otros dispositivos ha sido cerrada";
    }
}
