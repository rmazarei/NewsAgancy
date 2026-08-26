<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Inertia\Inertia;
use Sadegh19b\LaravelIranCities\Models\City;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('admin/Dashboard', [
            'stats' => [
                'news' => News::query()->count(),
                'categories' => Category::query()->count(),
                'cities' => City::query()->count(),
            ],
        ]);
    }
}
