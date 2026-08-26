<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Sadegh19b\LaravelIranCities\Models\City;

interface CityRepositoryInterface
{
    public function all(): Collection;

    public function find($id): ?City;

    public function create(array $data): City;

    public function update($id, array $data): City;

    public function delete($id): bool;

    public function paginate($perPage = 15): LengthAwarePaginator;
}
