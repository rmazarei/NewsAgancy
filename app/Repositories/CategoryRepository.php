<?php

namespace App\Repositories;

use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(): Collection
    {
        return Category::query()->orderBy('order')->orderBy('title')->get();
    }

    public function find($id): ?Category
    {
        return Category::query()->find($id);
    }

    public function create(array $data): Category
    {
        return Category::query()->create($data);
    }

    public function update($id, array $data): Category
    {
        $category = Category::query()->findOrFail($id);
        $category->update($data);

        return $category->fresh();
    }

    public function delete($id): bool
    {
        $category = Category::query()->findOrFail($id);

        return (bool) $category->delete();
    }

    public function paginate($perPage = 15): LengthAwarePaginator
    {
        return Category::query()->orderBy('order')->orderBy('title')->paginate($perPage);
    }
}
