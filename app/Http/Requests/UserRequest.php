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
            'address_id' => 'required|exists:address,id',
            'date' => 'required|date_format:Y-m-d',
            'phone' => 'required|max:14|min:9',
            'email' => 'required|max:100|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|max:100'
          ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response(['message' => 'Parametros inválidos!'], 400));
    }
}
