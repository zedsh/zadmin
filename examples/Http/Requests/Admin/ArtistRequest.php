<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArtistRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['string', 'required'],
            'description' => ['string', 'required'],
            'slug' => ['string', 'required'],
            'photo' => ['file'],
            'additional_photos.*' => ['file']
        ];
    }
}
