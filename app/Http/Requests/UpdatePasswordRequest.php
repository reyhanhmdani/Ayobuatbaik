<?php

namespace App\Http\Requests;

use Hash;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
        $user = $this->user();
        $isGoogleUser = !empty($user->gauth_id);

        $rules = [
            'new_password' => 'required|string|min:6|confirmed',
        ];

        if (!$isGoogleUser) {
            $rules['current_password'] = 'required|string';
        }
        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = $this->user();
            $isGoogleUser = !empty($user->gauth_id);

            if (!$isGoogleUser && $this->filled('current_password')) {
                if (!Hash::check($this->current_password, $user->password)) {
                    $validator->errors()->add('current_password', 'Password saat ini salah.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'current_password.required' => 'Password saat ini wajib diisi.',
        ];
    }
}
