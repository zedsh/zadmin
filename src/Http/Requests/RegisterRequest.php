<?php

namespace zedsh\zadmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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

            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'E-mail',
            'name' => 'Имя',
            'password' => 'Пароль',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Заявитель с такой почтой уже зарегистрирован.',
        ];
    }
}
