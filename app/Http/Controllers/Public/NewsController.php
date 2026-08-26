<?php

namespace App\Http\Controllers\Public;

use App\Contracts\NewsRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function __construct(
        protected NewsRepositoryInterface $newsRepository,
    ) {}

    public function index(Request $request)
    {
        $query = News::query()
            ->with(['categories', 'cities', 'media'])
            ->whereNotNull('published_at')
            ->orderByDesc('published_at');

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->integer('category'));
            });
        }

        $news = $query->paginate(9);

        $carouselNews = $this->newsRepository->getCarouselNews(5);

        return Inertia::render('public/NewsIndex', [
            'carouselNews' => $carouselNews,
            'news' => $news,
        ]);
    }

    public function show(string $slug)
    {
        $news = News::query()
            ->with(['categories', 'cities', 'media'])
            ->where('slug', $slug)
            ->firstOrFail();

        return Inertia::render('public/NewsShow', [
            'news' => $news,
        ]);
    }
}
