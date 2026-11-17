<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'kode' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'gudang' => 'required|string|max:50',
            'nama_rak' => 'nullable|string|max:50',
            'kapasitas' => 'required|integer|min:0',
            'terisi' => 'required|integer|min:0',
            'keterangan' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ];
    }
}