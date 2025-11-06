<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KategoriDonasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Boleh disesuaikan kalau kamu pakai auth
        return true;
    }

    public function rules(): array
    {
        $id = optional($this->route('kategori_donasi'))->id ?? $this->id;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('kategori_donasi', 'name')->ignore($id)],
            'deskripsi' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
        ];
    }
}
