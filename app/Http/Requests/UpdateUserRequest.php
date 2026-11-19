<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null
            && ($this->user()->isSuperAdmin() || $this->user()->hasPermission('user.manage'));
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'username' => ['required', 'string', 'max:60', 'regex:/^[A-Za-z0-9_.-]+$/', Rule::unique('users', 'username')->ignore($userId)],
            'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($userId)],
            'nip' => ['required', 'string', 'max:40', Rule::unique('users', 'nip')->ignore($userId)],
            'phone' => ['nullable', 'string', 'max:30'],
            'role_id' => ['required', 'integer', Rule::exists('roles', 'id')->where('status', true)],
            'division_id' => ['nullable', 'integer', 'exists:divisions,id'],
            'selected_hub_id' => ['nullable', 'integer', 'exists:hubs,id'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.unique' => 'Username sudah digunakan.',
            'email.unique' => 'Email sudah terdaftar.',
            'nip.unique' => 'NIP/NIK sudah terdaftar.',
            'role_id.exists' => 'Peran yang dipilih tidak valid.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ];
    }
}
