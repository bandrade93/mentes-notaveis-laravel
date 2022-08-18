<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'date' => 'required|date_format:Y-m-d',
            'phone' => 'required|regex:/^\([0-9]{2}\) [0-9]?[0-9]{5}-[0-9]{4}$/',
            'email' => 'required|max:100|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'string|min:6|max:12',
            'street' => 'required|max:100',
            'cep' => 'required|string|max:9|regex:/^\d{5}\-\d{3}$/',
            'number' => 'required|int',
            'city_id' => 'required|int'
          ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response(['message' => 'Parametros inválidos!'], 400));
    }
}
