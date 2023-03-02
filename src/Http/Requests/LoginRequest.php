<?php

namespace zedsh\zadmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required', 'string'],
            'remember' => ['string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Заголовок',
            'remember' => 'Запомнить меня',
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'Пользователь с таким e-mail не зарегистрирован.',
        ];
    }
}
