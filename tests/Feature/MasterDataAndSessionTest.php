<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Unit;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\Division;
use App\Models\Item;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase as BaseTestCase;

class MasterDataAndSessionTest extends BaseTestCase
{
    private ?User $user = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $role = Role::where('code', 'super_admin')->first();
        if (!$role) {
            $this->seed(\Database\Seeders\RolesAndUsersSeeder::class);
            $role = Role::where('code', 'super_admin')->first();
        }

        $this->user = User::create([
            'username' => 'test_admin_' . uniqid(),
            'email' => 'test_admin_' . uniqid() . '@astro.test',
            'password' => Hash::make('Password@123'),
            'nama_lengkap' => 'Master Data Admin',
            'nip' => 'MDA001',
            'phone' => '081299990001',
            'role_id' => $role->id,
            'status' => 'active',
        ]);
    }

    protected function tearDown(): void
    {
        if ($this->user) {
            $this->user->forceDelete();
        }
        parent::tearDown();
    }

    public function test_can_query_master_data_models(): void
    {
        $category = Category::create([
            'kode' => 'CAT-' . uniqid(),
            'nama' => 'Testing Category',
            'deskripsi' => 'Test Deskripsi',
            'status' => true,
        ]);
        $this->assertDatabaseHas('categories', ['id' => $category->id]);

        $unit = Unit::create([
            'kode' => 'UNT-' . uniqid(),
            'nama' => 'Testing Unit',
            'simbol' => 'TU',
            'status' => true,
        ]);
        $this->assertDatabaseHas('units', ['id' => $unit->id]);

        $location = Location::create([
            'kode' => 'LOC-' . uniqid(),
            'nama' => 'Rak Testing',
            'gudang' => 'WH01',
            'status' => true,
        ]);
        $this->assertDatabaseHas('locations', ['id' => $location->id]);

        $supplier = Supplier::create([
            'kode' => 'SUP-' . uniqid(),
            'nama' => 'PT Testing Supplier',
            'status' => true,
        ]);
        $this->assertDatabaseHas('suppliers', ['id' => $supplier->id]);

        $division = Division::create([
            'kode' => 'DIV-' . uniqid(),
            'nama' => 'Divisi Testing',
            'status' => true,
        ]);
        $this->assertDatabaseHas('divisions', ['id' => $division->id]);

        $item = Item::create([
            'sku' => 'SKU-' . uniqid(),
            'barcode' => 'BC-' . uniqid(),
            'nama' => 'Barang Testing',
            'category_id' => $category->id,
            'unit_id' => $unit->id,
            'location_id' => $location->id,
            'supplier_id' => $supplier->id,
            'division_id' => $division->id,
            'status' => 'Aktif',
            'stok_minimum' => 10,
            'harga_beli' => 50000,
            'harga_jual' => 75000,
        ]);
        $this->assertDatabaseHas('items', ['id' => $item->id]);

        // Cleanup
        $item->delete();
        $division->delete();
        $supplier->delete();
        $location->delete();
        $unit->delete();
        $category->delete();
    }

    public function test_can_manage_user_sessions(): void
    {
        $session = \App\Models\UserSession::create([
            'user_id' => $this->user->id,
            'session_id' => md5('dummy_session_' . uniqid()),
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0',
            'device_name' => 'Windows PC',
            'platform' => 'Windows',
            'browser' => 'Chrome',
            'last_activity_at' => now(),
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('user_sessions', [
            'id' => $session->id,
            'status' => 'active',
        ]);

        $controller = new \App\Http\Controllers\SessionController();
        $request = \Illuminate\Http\Request::create('/api/sessions', 'GET');
        $request->setUserResolver(fn () => $this->user);
        $request->setLaravelSession(session());

        $response = $controller->index($request);
        $this->assertEquals(200, $response->getStatusCode());

        $destroyRequest = \Illuminate\Http\Request::create('/api/sessions/' . $session->id, 'DELETE');
        $destroyRequest->setUserResolver(fn () => $this->user);
        $destroyResponse = $controller->destroy($destroyRequest, $session->id);
        $this->assertEquals(200, $destroyResponse->getStatusCode());

        $this->assertDatabaseHas('user_sessions', [
            'id' => $session->id,
            'status' => 'revoked',
        ]);

        $session->delete();
    }
}
