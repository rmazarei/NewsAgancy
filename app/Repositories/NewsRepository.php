<?php

namespace App\Repositories;

use App\Contracts\NewsRepositoryInterface;
use App\Models\News;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NewsRepository implements NewsRepositoryInterface
{
    public function all(): Collection
    {
        return News::query()->with(['categories', 'cities', 'media'])->get();
    }

    public function find($id): ?News
    {
        return News::query()->with(['categories', 'cities', 'media'])->find($id);
    }

    public function create(array $data): News
    {
        $news = News::query()->create($data);

        if (isset($data['categories'])) {
            $this->syncCategories($news, $data['categories']);
        }

        if (isset($data['cities'])) {
            $this->syncCities($news, $data['cities']);
        }

        return $news->fresh(['categories', 'cities', 'media']);
    }

    public function update($id, array $data): News
    {
        $news = News::query()->findOrFail($id);
        $news->update($data);

        if (array_key_exists('categories', $data)) {
            $this->syncCategories($news, $data['categories']);
        }

        if (array_key_exists('cities', $data)) {
            $this->syncCities($news, $data['cities']);
        }

        return $news->fresh(['categories', 'cities', 'media']);
    }

    public function delete($id): bool
    {
        $news = News::query()->findOrFail($id);

        return (bool) $news->delete();
    }

    public function paginate($perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = News::query()->with(['categories', 'cities', 'media'])
            ->when(! empty($filters['search']), function ($query) use ($filters) {
                $query->where('title', 'like', '%'.$filters['search'].'%');
            })
            ->when(! empty($filters['category_id']), function ($query) use ($filters) {
                $query->whereHas('categories', function ($query) use ($filters) {
                    $query->where('categories.id', $filters['category_id']);
                });
            })
            ->when(! empty($filters['city_id']), function ($query) use ($filters) {
                $query->whereHas('cities', function ($query) use ($filters) {
                    $query->where('cities.id', $filters['city_id']);
                });
            });

        return $query->orderByDesc('published_at')->orderByDesc('created_at')->paginate($perPage);
    }

    public function syncCategories(News $news, array $categoryIds): void
    {
        $news->categories()->sync($categoryIds);
    }

    public function syncCities(News $news, array $cityIds): void
    {
        $news->cities()->sync($cityIds);
    }

    public function getCarouselNews(int $limit = 5): Collection
    {
        return News::with('media')
            ->latest()
            ->take($limit)
            ->get();
    }
}
