<?php

namespace Tests\Feature;

use App\Models\Hub;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ZzTempSidebarCompareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');
        $_ENV['DB_CONNECTION'] = $_SERVER['DB_CONNECTION'] = 'sqlite';
        $_ENV['DB_DATABASE'] = $_SERVER['DB_DATABASE'] = ':memory:';

        parent::setUp();
    }

    public function test_dump_dua_halaman(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $user = User::where('username', 'superadmin')->firstOrFail();
        $hub = Hub::first();
        $user->forceFill(['selected_city_id' => $hub->city_id, 'selected_hub_id' => $hub->id])->save();

        $out = getenv('TMPDIR') ?: sys_get_temp_dir();
        foreach ([['/admin/data-barang', 'data-barang'], ['/admin/log-aktivitas', 'log-aktivitas']] as [$url, $name]) {
            $res = $this->actingAs($user)->get($url);
            $res->assertStatus(200);
            file_put_contents("$out/$name-render.html", $res->getContent());
            echo "\n[$name] ".strlen($res->getContent())." byte";
        }
        echo "\n";
    }
}
