<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled via middleware
    }

    public function rules(): array
    {
        return [
            'kode' => 'required|string|max:20|unique:categories,kode',
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:1000',
            'status' => 'nullable|boolean|default:true',
        ];
    }
}
