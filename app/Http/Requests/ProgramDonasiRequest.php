<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramDonasiRequest extends FormRequest
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
        $programId = $this->route('program'); // untuk update ignore unique slug jika perlu

        return [
            'title' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_donasi,id',
            'penggalang_id' => 'required|exists:penggalang_dana,id',
            'target_amount' => 'required|numeric|min:1',
            'collected_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'short_description' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|string|in:active,draft,closed,archived',
            'verified' => 'nullable|boolean',
            'featured' => 'nullable|boolean', 
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Judul program wajib diisi.',
            'title.max' => 'Judul program maksimal 255 karakter.',

            'penggalang_id.required' => 'Penggalang dana wajib dipilih.',
            'penggalang_id.exists' => 'Penggalang dana yang dipilih tidak valid.',

            'kategori_id.required' => 'Kategori program wajib dipilih.',
            'kategori_id.exists' => 'Kategori program yang dipilih tidak valid.',

            'target_amount.required' => 'Target donasi wajib diisi.',
            'target_amount.numeric' => 'Target donasi harus berupa angka.',
            'target_amount.min' => 'Target donasi minimal Rp10.000.',

            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date' => 'Tanggal mulai tidak valid.',

            'end_date.date' => 'Tanggal akhir tidak valid.',
            'end_date.after_or_equal' => 'Tanggal akhir tidak boleh sebelum tanggal mulai.',

            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar hanya boleh jpeg, png, jpg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',

            'deskripsi.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
