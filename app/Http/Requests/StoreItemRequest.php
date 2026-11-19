<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && ($user->isSuperAdmin()
            || $user->hasPermission('product.manage')
            || $user->hasPermission('master.manage'));
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
            'hub_id' => 'nullable|exists:hubs,id',
            'stok_minimum' => 'nullable|integer|min:0',
            'harga_beli' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string|max:1000',
            'foto' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Stok Kritis',
        ];
    }

    public function messages(): array
    {
        return [
            'sku.required' => 'Kode SKU wajib diisi.',
            'sku.unique' => 'Kode SKU sudah terdaftar.',
            'barcode.required' => 'Barcode wajib diisi.',
            'barcode.unique' => 'Barcode sudah terdaftar.',
            'nama.required' => 'Nama barang wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'unit_id.required' => 'Satuan wajib dipilih.',
            'location_id.required' => 'Lokasi rak wajib dipilih.',
            'status.in' => 'Status harus Aktif atau Stok Kritis.',
        ];
    }
}
