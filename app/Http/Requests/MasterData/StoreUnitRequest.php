<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'kode' => 'required|string|max:20|unique:units,kode',
            'nama' => 'required|string|max:100',
            'keterangan' => 'nullable|string|max:255',
            'status' => 'nullable|boolean|default:true',
        ];
    }
}
