<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gambar' => 'nullable|image|max:2048',
            'url' => 'nullable|string',
            'urutan' => 'required|integer',
            'alt_text' => 'nullable|string|max:255',
        ];
    }
}
