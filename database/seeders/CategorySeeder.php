<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'سیاست',
            'اقتصاد',
            'فرهنگ',
            'ورزشی',
            'علمی',
            'جهان',
        ];

        foreach ($categories as $index => $title) {
            Category::firstOrCreate(
                ['title' => $title],
                ['order' => $index + 1],
            );
        }
    }
}
