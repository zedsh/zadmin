<?php

namespace App\Http\Requests\Admin;

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
            'name' => ['string', 'required'],
            'email' => ['string', 'required'],
            'login' => ['string', 'required'],
            'password' => ['string', 'confirmed', 'nullable'],
            'notification_news' => ['boolean'],
        ];
    }
}
