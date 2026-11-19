<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'kode' => 'required|string|max:30|unique:suppliers,kode',
            'nama' => 'required|string|max:150',
            'pic' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'kota' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:300',
            'hub_id' => 'nullable|exists:hubs,id',
            'status' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode supplier wajib diisi.',
            'kode.unique' => 'Kode supplier sudah terdaftar.',
            'nama.required' => 'Nama supplier wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}
