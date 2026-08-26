<?php

namespace App\Contracts;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function all(): Collection;

    public function find($id): ?Category;

    public function create(array $data): Category;

    public function update($id, array $data): Category;

    public function delete($id): bool;

    public function paginate($perPage = 15): LengthAwarePaginator;
}
