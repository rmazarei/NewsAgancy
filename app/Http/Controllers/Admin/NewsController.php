<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\NewsRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNewsRequest;
use App\Http\Requests\Admin\UpdateNewsRequest;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Sadegh19b\LaravelIranCities\Models\City;

class NewsController extends Controller
{
    public function __construct(
        protected NewsRepositoryInterface $newsRepository,
    ) {}

    public function index(Request $request)
    {
        $news = $this->newsRepository->paginate(12, $request->only(['search', 'category_id', 'city_id']));

        return Inertia::render('admin/news/Index', [
            'news' => $news,
            'categories' => Category::query()->orderBy('title')->get(),
            'cities' => City::query()->orderBy('name')->get(),
            'filters' => $request->only(['search', 'category_id', 'city_id']),
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/news/Create', [
            'categories' => Category::query()->orderBy('title')->get(),
            'cities' => City::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreNewsRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $news = $this->newsRepository->create($data);

        $this->handleMedia($news, $request);

        return redirect()->route('admin.news.index')->with('success', 'خبر با موفقیت ثبت شد.');
    }

    public function edit(News $news)
    {
        $news->load(['categories', 'cities', 'media']);

        return Inertia::render('admin/news/Edit', [
            'news' => $news,
            'categories' => Category::query()->orderBy('title')->get(),
            'cities' => City::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $data = $request->validated();
        $this->newsRepository->update($news->id, $data);

        if ($request->hasFile('main_image')) {
            $news->clearMediaCollection('main_image');
            $news->addMedia($request->file('main_image'))->toMediaCollection('main_image');
        }

        if ($request->hasFile('gallery')) {
            $news->clearMediaCollection('gallery');
            foreach ($request->file('gallery') as $image) {
                $news->addMedia($image)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.news.index')->with('success', 'خبر با موفقیت بروزرسانی شد.');
    }

    public function destroy(News $news)
    {
        $this->newsRepository->delete($news->id);

        return redirect()->route('admin.news.index')->with('success', 'خبر با موفقیت حذف شد.');
    }

    protected function handleMedia(News $news, Request $request): void
    {
        if ($request->hasFile('main_image')) {
            $news->addMedia($request->file('main_image'))->toMediaCollection('main_image');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $news->addMedia($image)->toMediaCollection('gallery');
            }
        }
    }
}
