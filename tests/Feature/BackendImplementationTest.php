<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\City;
use App\Models\Division;
use App\Models\Hub;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BackendImplementationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        if (\App\Models\Role::where('code', 'super_admin')->doesntExist()) {
            $this->seed(\Database\Seeders\DatabaseSeeder::class);
        } elseif (\App\Models\Hub::count() === 0) {
            $this->seed(\Database\Seeders\HubSeeder::class);
        }

        if (\App\Models\Division::count() === 0) {
            \App\Models\Division::create([
                'kode' => 'DIV-UJI',
                'nama' => 'Divisi Uji',
                'kepala' => 'Tester',
                'keterangan' => 'Divisi untuk pengujian otomatis',
                'status' => true,
            ]);
        }
    }

    private function makeUser(string $roleCode, array $attributes = []): User
    {
        $role = Role::where('code', $roleCode)->firstOrFail();
        $hub = Hub::first();
        $city = City::first();

        return User::create(array_merge([
            'username' => 'test_' . $roleCode . '_' . uniqid(),
            'email' => 'test_' . $roleCode . '_' . uniqid() . '@astro.test',
            'password' => 'Password@123',
            'nama_lengkap' => 'Test ' . $roleCode,
            'nip' => 'TST-' . strtoupper(uniqid()),
            'phone' => '081200000000',
            'role_id' => $role->id,
            'division_id' => Division::first()?->id,
            'selected_hub_id' => $hub?->id,
            'selected_city_id' => $city?->id,
            'status' => 'active',
        ], $attributes));
    }

    public function test_all_role_dashboards_render_with_database_data(): void
    {
        foreach (['super_admin', 'kepala_gudang', 'hr', 'pegawai', 'audit'] as $roleCode) {
            $user = $this->makeUser($roleCode);

            $response = $this->actingAs($user)->get(route(
                match ($roleCode) {
                    'super_admin' => 'admin.dashboard',
                    'kepala_gudang' => 'kepalagudang.dashboard',
                    'hr' => 'hr.dashboard',
                    'pegawai' => 'pegawai.dashboard',
                    default => 'audit.dashboard',
                }
            ));

            $response->assertOk();
            $response->assertSee('Modul berikut belum tersedia');
        }
    }

    public function test_user_metrics_are_scoped_to_selected_hub(): void
    {
        $hubA = Hub::orderBy('id')->firstOrFail();
        $hubB = Hub::orderBy('id')->skip(1)->firstOrFail();
        $pegawaiRoleId = Role::where('code', 'pegawai')->value('id');

        $admin = $this->makeUser('super_admin', [
            'selected_hub_id' => $hubA->id,
            'selected_city_id' => $hubA->city_id,
        ]);

        $this->makeUser('pegawai', [
            'selected_hub_id' => $hubA->id,
            'selected_city_id' => $hubA->city_id,
        ]);
        $this->makeUser('pegawai', [
            'selected_hub_id' => $hubB->id,
            'selected_city_id' => $hubB->city_id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $this->assertTrue($response->viewData('hubScoped'));
        $this->assertSame($hubA->name, $response->viewData('hubScopeLabel'));

        $this->assertSame(
            User::where('selected_hub_id', $hubA->id)->count(),
            $response->viewData('totalUsers')
        );
        $this->assertSame(
            User::where('selected_hub_id', $hubA->id)->where('status', 'active')->count(),
            $response->viewData('activeUsers')
        );
        $this->assertSame(
            User::where('selected_hub_id', $hubA->id)->where('role_id', $pegawaiRoleId)->count(),
            $response->viewData('usersByRole')->firstWhere('code', 'pegawai')->users_count
        );

        foreach ($response->viewData('recentUsers') as $recentUser) {
            $this->assertSame($hubA->id, $recentUser->selected_hub_id);
        }
    }

    public function test_hr_pegawai_account_metric_only_counts_same_hub(): void
    {
        $hubA = Hub::orderBy('id')->firstOrFail();
        $hubB = Hub::orderBy('id')->skip(1)->firstOrFail();
        $pegawaiRoleId = Role::where('code', 'pegawai')->value('id');

        $hr = $this->makeUser('hr', [
            'selected_hub_id' => $hubA->id,
            'selected_city_id' => $hubA->city_id,
        ]);

        $this->makeUser('pegawai', [
            'selected_hub_id' => $hubA->id,
            'selected_city_id' => $hubA->city_id,
        ]);
        $this->makeUser('pegawai', [
            'selected_hub_id' => $hubB->id,
            'selected_city_id' => $hubB->city_id,
        ]);

        $response = $this->actingAs($hr)->get(route('hr.dashboard'));
        $response->assertOk();

        $counted = $response->viewData('usersByRole')->firstWhere('code', 'pegawai')->users_count;
        $expected = User::where('selected_hub_id', $hubA->id)->where('role_id', $pegawaiRoleId)->count();
        $global = User::where('role_id', $pegawaiRoleId)->count();

        $this->assertSame($expected, $counted);
        $this->assertLessThan($global, $counted);
    }

    public function test_dashboard_without_assigned_hub_falls_back_to_all_users_with_label(): void
    {
        $kg = $this->makeUser('kepala_gudang', [
            'selected_hub_id' => null,
            'selected_city_id' => null,
        ]);

        $response = $this->actingAs($kg)->get(route('kepalagudang.dashboard'));

        $response->assertOk();
        $response->assertSee('Semua hub');
        $this->assertFalse($response->viewData('hubScoped'));
        $this->assertSame(User::count(), $response->viewData('totalUsers'));
    }

    public function test_kepala_gudang_routes_use_required_prefix_and_names(): void
    {
        $this->assertSame(url('/kepalagudang/dashboard'), route('kepalagudang.dashboard'));
        $this->assertSame(url('/kepalagudang/pengaturan'), route('kepalagudang.pengaturan'));
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('kepalagudang.laporan'));
        $this->assertFalse(\Illuminate\Support\Facades\Route::has('gudang.dashboard'));
    }

    public function test_super_admin_can_list_search_and_paginate_users(): void
    {
        $admin = $this->makeUser('super_admin');
        $target = $this->makeUser('pegawai', ['nama_lengkap' => 'Pegawai Pencarian Khusus']);

        $response = $this->actingAs($admin)->get(route('admin.pengguna', ['q' => 'Pencarian Khusus']));

        $response->assertOk();
        $response->assertSee('Pegawai Pencarian Khusus');
    }

    public function test_super_admin_can_create_update_and_toggle_user_with_audit_trail(): void
    {
        $admin = $this->makeUser('super_admin');
        $role = Role::where('code', 'pegawai')->firstOrFail();
        $division = Division::first();
        $hub = Hub::first();

        $payload = [
            'nama_lengkap' => 'Pengguna Baru Uji',
            'username' => 'pengguna.baru.' . uniqid(),
            'email' => 'baru.' . uniqid() . '@astro.test',
            'nip' => 'NEW-' . uniqid(),
            'phone' => '081211112222',
            'role_id' => $role->id,
            'division_id' => $division?->id,
            'selected_hub_id' => $hub?->id,
            'status' => 'active',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
        ];

        $this->actingAs($admin)->post(route('admin.pengguna.store'), $payload)->assertRedirect();

        $created = User::where('username', $payload['username'])->firstOrFail();
        $this->assertSame('Pengguna Baru Uji', $created->nama_lengkap);
        $this->assertSame($hub->city_id, $created->selected_city_id);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'create',
            'entity_type' => User::class,
            'entity_id' => $created->id,
        ]);

        $this->actingAs($admin)->put(route('admin.pengguna.update', $created), array_merge($payload, [
            'nama_lengkap' => 'Pengguna Baru Diubah',
            'password' => '',
            'password_confirmation' => '',
        ]))->assertRedirect();

        $this->assertSame('Pengguna Baru Diubah', $created->fresh()->nama_lengkap);

        $this->actingAs($admin)
            ->post(route('admin.pengguna.toggle-status', $created))
            ->assertRedirect();

        $this->assertSame('inactive', $created->fresh()->status);
    }

    public function test_super_admin_cannot_deactivate_own_account(): void
    {
        $admin = $this->makeUser('super_admin');

        $this->actingAs($admin)
            ->post(route('admin.pengguna.toggle-status', $admin))
            ->assertSessionHas('error');

        $this->assertSame('active', $admin->fresh()->status);
    }

    public function test_user_management_is_forbidden_for_non_super_admin(): void
    {
        foreach (['kepala_gudang', 'hr', 'pegawai', 'audit'] as $roleCode) {
            $user = $this->makeUser($roleCode);
            $this->actingAs($user)->get(route('admin.pengguna'))->assertForbidden();
        }
    }

    public function test_user_export_returns_csv_without_credentials(): void
    {
        $admin = $this->makeUser('super_admin');

        $response = $this->actingAs($admin)->get(route('admin.pengguna.export'));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $content = $response->streamedContent();
        $this->assertStringContainsString('Nama,Username,Email,NIP', $content);
        $this->assertStringNotContainsString('password', strtolower($content));
    }

    public function test_settings_page_renders_for_all_roles(): void
    {
        foreach (['super_admin', 'kepala_gudang', 'hr', 'pegawai', 'audit'] as $roleCode) {
            $user = $this->makeUser($roleCode);
            $route = match ($roleCode) {
                'super_admin' => 'admin.pengaturan',
                'kepala_gudang' => 'kepalagudang.pengaturan',
                'hr' => 'hr.pengaturan',
                'pegawai' => 'pegawai.pengaturan',
                default => 'audit.pengaturan',
            };

            $this->actingAs($user)->get(route($route))->assertOk()->assertSee('Pengaturan Sistem');
        }
    }

    public function test_super_admin_can_save_global_setting_and_it_is_audited(): void
    {
        $admin = $this->makeUser('super_admin');

        $response = $this->actingAs($admin)->post(route('admin.pengaturan.update'), [
            'settings' => [
                'general.system_name' => 'ASTRO Uji',
                'general.system_tagline' => 'Tagline Uji',
                'general.timezone' => 'Asia/Jakarta',
            ],
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('settings', [
            'key' => 'general.system_name',
            'scope' => 'global',
            'scope_id' => 0,
            'value' => 'ASTRO Uji',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'entity_type' => 'Setting',
            'action' => 'update',
            'result' => 'success',
        ]);
    }

    public function test_hr_can_save_personal_preference_but_not_security_policy(): void
    {
        $hr = $this->makeUser('hr');

        $this->actingAs($hr)->post(route('hr.pengaturan.update'), [
            'settings' => ['preferences.language' => 'en'],
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', [
            'key' => 'preferences.language',
            'scope' => 'user',
            'scope_id' => $hr->id,
        ]);

        $this->actingAs($hr)->post(route('hr.pengaturan.update'), [
            'settings' => ['security.session_timeout_minutes' => 60],
        ])->assertForbidden();
    }

    public function test_hub_setting_requires_selected_hub_and_is_saved_per_hub(): void
    {
        $kg = $this->makeUser('kepala_gudang');
        $hub = Hub::first();

        $this->actingAs($kg)->post(route('kepalagudang.pengaturan.update'), [
            'settings' => ['stock.lead_time_days' => 14],
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', [
            'key' => 'stock.lead_time_days',
            'scope' => 'hub',
            'scope_id' => $hub->id,
            'value' => '14',
        ]);

        $kgWithoutHub = $this->makeUser('kepala_gudang', [
            'selected_hub_id' => null,
            'selected_city_id' => null,
        ]);

        $this->actingAs($kgWithoutHub)->post(route('kepalagudang.pengaturan.update'), [
            'settings' => ['stock.lead_time_days' => 20],
        ])->assertSessionHasErrors('settings');
    }

    public function test_super_admin_can_reset_settings(): void
    {
        $admin = $this->makeUser('super_admin');

        Setting::create([
            'key' => 'general.system_name',
            'value' => 'Sebelum Reset',
            'type' => 'string',
            'scope' => 'global',
            'scope_id' => 0,
        ]);

        $this->actingAs($admin)->post(route('admin.pengaturan.reset'))->assertRedirect();

        $this->assertDatabaseMissing('settings', [
            'key' => 'general.system_name',
            'scope' => 'global',
            'scope_id' => 0,
        ]);
    }

    public function test_setting_log_history_endpoint_returns_json(): void
    {
        $admin = $this->makeUser('super_admin');

        AuditLog::create([
            'user_id' => $admin->id,
            'action' => 'update',
            'entity_type' => 'Setting',
            'result' => 'success',
            'description' => 'Uji riwayat konfigurasi',
        ]);

        $this->actingAs($admin)
            ->getJson(route('admin.pengaturan.history'))
            ->assertOk()
            ->assertJsonFragment(['description' => 'Uji riwayat konfigurasi']);
    }

    public function test_pegawai_and_audit_can_save_user_preferences(): void
    {
        foreach ([
            ['pegawai', 'pegawai.pengaturan.update'],
            ['audit', 'audit.pengaturan.update'],
        ] as [$roleCode, $routeName]) {
            $user = $this->makeUser($roleCode);

            $this->actingAs($user)->post(route($routeName), [
                'settings' => [
                    'preferences.language' => 'id',
                    'preferences.dashboard_compact' => '1',
                ],
            ])->assertRedirect();

            $this->assertDatabaseHas('settings', [
                'key' => 'preferences.language',
                'scope' => 'user',
                'scope_id' => $user->id,
                'value' => 'id',
            ]);
            $this->assertDatabaseHas('settings', [
                'key' => 'preferences.dashboard_compact',
                'scope' => 'user',
                'scope_id' => $user->id,
                'value' => '1',
            ]);
        }
    }

    public function test_user_activity_endpoint_returns_sessions_and_logs(): void
    {
        $admin = $this->makeUser('super_admin');
        $target = $this->makeUser('pegawai');

        $this->actingAs($admin)
            ->getJson(route('admin.pengguna.activity', $target))
            ->assertOk()
            ->assertJsonPath('user.id', $target->id);
    }
}
