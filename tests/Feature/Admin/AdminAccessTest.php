<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Sadegh19b\LaravelIranCities\Models\City;
use Sadegh19b\LaravelIranCities\Models\County;
use Sadegh19b\LaravelIranCities\Models\Province;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_requires_admin_role(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_dashboard_as_admin(): void
    {
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertOk();
    }

    public function test_admin_can_create_news(): void
    {
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('admin');

        $category = Category::factory()->create(['title' => 'اقتصاد']);
        $province = Province::query()->create(['name' => 'تهران', 'tel_prefix' => '021']);
        $county = County::query()->create(['name' => 'تهران', 'province_id' => $province->id]);
        $city = City::query()->create([
            'name' => 'تهران',
            'province_id' => $province->id,
            'county_id' => $county->id,
        ]);

        $response = $this->actingAs($user)->post(route('admin.news.store'), [
            'title' => 'خبر مدیریتی',
            'content' => '<p>محتوای خبر جدید</p>',
            'published_at' => now()->toDateTimeString(),
            'categories' => [$category->id],
            'cities' => [$city->id],
        ]);

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news', ['title' => 'خبر مدیریتی']);
    }
}
