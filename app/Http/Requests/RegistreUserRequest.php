<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistreUserRequest extends FormRequest
{

    public function attributes()
    {
        return [
            'username' => 'usuario',
            'password' => 'contraseña',
            'name' => 'nombre',
            'email' => 'correo',
            'photo' => 'foto',
            /* 'state_id' => 'estado',
            'town_id' => 'municipio', */
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
            'username' => 'required|unique:users',
            'password' => 'required|min:8|confirmed',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.\Request::instance()->id,
            'photo' => 'required|mimes:jpeg,jpg,png',
        
        ];
    }
}
