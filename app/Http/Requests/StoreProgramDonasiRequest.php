<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramDonasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'string|unique:program_donasi,slug',

            'kategori_id' => 'required|exists:kategori_donasi,id',
            'penggalang_id' => 'required|exists:penggalang_dana,id',

            'target_amount' => 'required|numeric|min:1',
            'collected_amount' => 'nullable|numeric|min:0',

            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',

            'short_description' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',

            'status' => 'nullable|string|in:draft,active,closed,archived',
            'verified' => 'nullable|boolean',
            'featured' => 'nullable|boolean',

            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul program wajib diisi.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.unique' => 'Slug sudah digunakan program lain.',

            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori tidak valid.',

            'penggalang_id.required' => 'Penggalang dana wajib dipilih.',
            'penggalang_id.exists' => 'Penggalang dana tidak valid.',

            'target_amount.required' => 'Target donasi wajib diisi.',
            'target_amount.numeric' => 'Target donasi harus berupa angka.',
            'target_amount.min' => 'Target donasi minimal 1.',

            'collected_amount.numeric' => 'Jumlah terkumpul harus berupa angka.',
            'collected_amount.min' => 'Jumlah terkumpul minimal 0.',

            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date' => 'Format tanggal mulai tidak valid.',

            'end_date.date' => 'Format tanggal selesai tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',

            'short_description.max' => 'Deskripsi singkat maksimal 255 karakter.',

            'status.in' => 'Status tidak valid.',
            'verified.boolean' => 'Format verified tidak valid.',
            'featured.boolean' => 'Format featured tidak valid.',

            'gambar.image' => 'File gambar harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
