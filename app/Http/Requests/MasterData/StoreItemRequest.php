<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'sku' => 'required|string|max:50|unique:items,sku',
            'barcode' => 'required|string|max:50|unique:items,barcode',
            'nama' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'location_id' => 'required|exists:locations,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'division_id' => 'nullable|exists:divisions,id',
            'deskripsi' => 'nullable|string|max:1000',
            'foto' => 'nullable|string|max:255',
            'status' => 'required|string|in:Aktif,Nonaktif',
            'stok_minimum' => 'nullable|integer|min:0',
            'harga_beli' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
        ];
    }
}