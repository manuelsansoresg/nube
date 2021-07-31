<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditUserRequest extends FormRequest
{
    public function attributes()
    {
        return [
            'username' => 'usuario',
            'name' => 'nombre',
            'email' => 'correo',
            'photo' => 'foto',
           
        ];
    }

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
            'username' => 'unique:users,username,'.Auth::id(),
            'name' => 'required',
            'email' => 'email|unique:users,email,'. Auth::id(),
            'photo' => 'mimes:jpeg,jpg,png',
            
        ];
    }
}
