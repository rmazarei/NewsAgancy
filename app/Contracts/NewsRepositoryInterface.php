<?php

namespace App\Contracts;

use App\Models\News;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface NewsRepositoryInterface
{
    public function all(): Collection;

    public function find($id): ?News;

    public function create(array $data): News;

    public function update($id, array $data): News;

    public function delete($id): bool;

    public function paginate($perPage = 15, array $filters = []): LengthAwarePaginator;

    public function syncCategories(News $news, array $categoryIds): void;

    public function syncCities(News $news, array $cityIds): void;

    public function getCarouselNews(int $limit = 5): Collection;
}
