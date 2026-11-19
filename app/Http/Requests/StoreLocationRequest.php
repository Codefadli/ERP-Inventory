<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
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
            'kode' => 'required|string|max:30|unique:locations,kode',
            'nama' => 'required|string|max:100',
            'gudang' => 'required|string|max:100',
            'nama_rak' => 'nullable|string|max:100',
            'kapasitas' => 'nullable|integer|min:0',
            'terisi' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string|max:500',
            'hub_id' => 'nullable|exists:hubs,id',
            'status' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode lokasi wajib diisi.',
            'kode.unique' => 'Kode lokasi sudah terdaftar.',
            'nama.required' => 'Nama lokasi / rak wajib diisi.',
            'gudang.required' => 'Nama gudang wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}
