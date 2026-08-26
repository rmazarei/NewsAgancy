<?php

namespace App\Repositories;

use App\Contracts\CityRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Sadegh19b\LaravelIranCities\Models\City;

class CityRepository implements CityRepositoryInterface
{
    public function all(): Collection
    {
        return City::query()->with(['province', 'county'])->orderBy('name')->get();
    }

    public function find($id): ?City
    {
        return City::query()->with(['province', 'county'])->find($id);
    }

    public function create(array $data): City
    {
        return City::query()->create($data);
    }

    public function update($id, array $data): City
    {
        $city = City::query()->findOrFail($id);
        $city->update($data);

        return $city->fresh();
    }

    public function delete($id): bool
    {
        $city = City::query()->findOrFail($id);

        return (bool) $city->delete();
    }

    public function paginate($perPage = 15): LengthAwarePaginator
    {
        return City::query()->with(['province', 'county'])->orderBy('name')->paginate($perPage);
    }
}
