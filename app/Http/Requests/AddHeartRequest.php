<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddHeartRequest extends FormRequest
{
    public function attributes()
    {
        return [
            'icorazones' => 'corazones'
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
            'icorazones' => 'required|numeric|integer|min:1'
        ];
    }
}
