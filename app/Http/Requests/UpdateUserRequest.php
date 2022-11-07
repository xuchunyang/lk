<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', 'regex:/^[a-z0-9_]+$/ui', Rule::unique('users')->ignore($this->user->id)],
            'email' => ['nullable', 'email'],
            'new-password' => ['nullable', Password::min(4)],
            'avatar' => ['image', 'max:200', 'dimensions:ratio=1/1'],
        ];
    }
}
