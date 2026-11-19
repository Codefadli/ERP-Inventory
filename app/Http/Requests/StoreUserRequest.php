<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null
            && ($this->user()->isSuperAdmin() || $this->user()->hasPermission('user.manage'));
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'username' => ['required', 'string', 'max:60', 'regex:/^[A-Za-z0-9_.-]+$/', 'unique:users,username'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email'],
            'nip' => ['required', 'string', 'max:40', 'unique:users,nip'],
            'phone' => ['nullable', 'string', 'max:30'],
            'role_id' => ['required', 'integer', Rule::exists('roles', 'id')->where('status', true)],
            'division_id' => ['nullable', 'integer', 'exists:divisions,id'],
            'selected_hub_id' => ['nullable', 'integer', 'exists:hubs,id'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.unique' => 'Email sudah terdaftar.',
            'nip.unique' => 'NIP/NIK sudah terdaftar.',
            'role_id.exists' => 'Peran yang dipilih tidak valid.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ];
    }
}
