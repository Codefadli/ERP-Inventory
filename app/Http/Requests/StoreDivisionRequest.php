<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDivisionRequest extends FormRequest
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
            'kode' => 'required|string|max:30|unique:divisions,kode',
            'nama' => 'required|string|max:120',
            'kepala' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string|max:500',
            'hub_id' => 'nullable|exists:hubs,id',
            'status' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode departemen wajib diisi.',
            'kode.unique' => 'Kode departemen sudah terdaftar.',
            'nama.required' => 'Nama departemen wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}
