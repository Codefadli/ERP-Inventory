<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase as BaseTestCase;

class ProfileUpdateTest extends BaseTestCase
{
    private ?User $tempUser = null;

    protected function setUp(): void
    {
        parent::setUp();

        // Platform ini memiliki quirk env detection (APP_ENV test tidak terdeteksi),
        // sehingga bypass CSRF secara eksplisit (standar testing Laravel).
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $role = Role::where('code', 'pegawai')->first();
        if (!$role) {
            $this->markTestSkipped('Role pegawai tidak ditemukan');
        }

        $this->tempUser = User::create([
            'username' => 'profile_test_' . uniqid(),
            'email' => 'profile_test_' . uniqid() . '@astro.test',
            'password' => Hash::make('Test@12345'),
            'nama_lengkap' => 'User Test Profil',
            'nip' => 'TST001',
            'phone' => '081200000001',
            'role_id' => $role->id,
            'status' => 'active',
        ]);
    }

    protected function tearDown(): void
    {
        if ($this->tempUser) {
            $this->tempUser->forceDelete();
        }
        parent::tearDown();
    }

    public function test_update_profil_menyimpan_nama_email_phone(): void
    {
        $this->actingAs($this->tempUser);

        $this->from(route('profile.index'))
            ->put(route('profile.update'), [
                'nama_lengkap' => 'User Test Profil Updated',
                'phone' => '081200000099',
                'email' => $this->tempUser->email,
            ])
            ->assertRedirect(route('profile.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $this->tempUser->id,
            'nama_lengkap' => 'User Test Profil Updated',
            'phone' => '081200000099',
        ]);
    }

    public function test_update_profil_menolak_email_yang_dipakai_user_lain(): void
    {
        $other = User::where('username', 'superadmin')->first();
        if (!$other) {
            $this->markTestSkipped('User superadmin tidak ditemukan');
        }

        $this->actingAs($this->tempUser);

        $this->from(route('profile.index'))
            ->put(route('profile.update'), [
                'nama_lengkap' => 'User Test Profil',
                'phone' => '081200000001',
                'email' => $other->email,
            ])
            ->assertSessionHasErrors('email');
    }

    public function test_ganti_password_berhasil_dengan_password_lama_benar(): void
    {
        $this->tempUser->update(['password' => Hash::make('Pegawai@123')]);

        $this->actingAs($this->tempUser);

        $this->from(route('profile.index'))
            ->put(route('profile.password'), [
                'current_password' => 'Pegawai@123',
                'password' => 'Pegawai@1234',
                'password_confirmation' => 'Pegawai@1234',
            ])
            ->assertRedirect(route('profile.index'))
            ->assertSessionHas('success');

        $this->assertTrue(Hash::check('Pegawai@1234', $this->tempUser->fresh()->password));
    }

    public function test_ganti_password_ditolak_saat_password_lama_salah(): void
    {
        $this->tempUser->update(['password' => Hash::make('Pegawai@123')]);

        $this->actingAs($this->tempUser);

        $this->from(route('profile.index'))
            ->put(route('profile.password'), [
                'current_password' => 'salah',
                'password' => 'Pegawai@1234',
                'password_confirmation' => 'Pegawai@1234',
            ])
            ->assertSessionHasErrors('current_password');
    }

    public function test_route_lama_profile_edit_dan_halaman_baru_tidak_500(): void
    {
        $this->actingAs($this->tempUser);

        // Halaman profil baru (semua role)
        $this->get(route('profile.index'))->assertOk();
        // Route lama profile.edit kini mengarah ke halaman profil tunggal
        $this->get(route('profile.edit'))->assertOk();
    }
}
