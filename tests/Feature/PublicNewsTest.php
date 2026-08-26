<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PublicNewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_latest_news(): void
    {
        $category = Category::factory()->create(['title' => 'سیاسی']);
        $news = News::factory()->create([
            'title' => 'عنوان خبر تستی',
            'content' => '<p>متن خبر تستی</p>',
            'published_at' => now(),
        ]);
        $news->categories()->attach($category->id);

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('public/NewsIndex')
                ->has('news.data', 1));
    }

    public function test_news_detail_page_is_accessible(): void
    {
        $category = Category::factory()->create(['title' => 'ورزشی']);
        $news = News::factory()->create([
            'title' => 'خبر صفحه‌جزئیات',
            'content' => '<p>متن صفحه جزئیات</p>',
            'published_at' => now(),
        ]);
        $news->categories()->attach($category->id);

        $response = $this->get(route('news.show', $news->slug));

        $response->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('public/NewsShow')
                ->where('news.title', 'خبر صفحه‌جزئیات'));
    }
}
