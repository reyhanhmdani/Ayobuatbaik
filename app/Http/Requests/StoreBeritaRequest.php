<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeritaRequest extends FormRequest
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
        return [
            'judul' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string',
            'konten' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
            'tanggal' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul berita wajib diisi.',
            'gambar.image' => 'File gambar harus berupa gambar.',
            'tanggal.required' => 'Tanggal berita wajib diisi.',
        ];
    }
}
