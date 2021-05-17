<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'phone'=> 'required|max:14|min:9'
          ];
    }
}
