<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email," . $userId,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama lengkap wajib di isi',
            'email.required' => 'Email wajib di isi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah sudah di gunakan oleh akun lain',
        ];
    }
}
