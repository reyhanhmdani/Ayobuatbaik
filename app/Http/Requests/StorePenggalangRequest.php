<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenggalangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:individu,yayasan,komunitas',
            'kontak' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama penggalang wajib diisi.',
            'tipe.required' => 'Tipe penggalang wajib dipilih.',
            'foto.image' => 'File foto harus berupa gambar.',
        ];
    }
}
