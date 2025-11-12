<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKategoriDonasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->kategori_donasi->id;
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('kategori_donasi', 'name')->ignore($id)],
            'deskripsi' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
