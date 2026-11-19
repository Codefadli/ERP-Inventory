<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && ($user->isSuperAdmin()
            || $user->hasPermission('master.manage'));
    }

    public function rules(): array
    {
        return [
            'kode' => 'required|string|max:30|unique:categories,kode',
            'nama' => 'required|string|max:120',
            'deskripsi' => 'nullable|string|max:500',
            'hub_id' => 'nullable|exists:hubs,id',
            'status' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode kategori wajib diisi.',
            'kode.unique' => 'Kode kategori sudah terdaftar.',
            'nama.required' => 'Nama kategori wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}
