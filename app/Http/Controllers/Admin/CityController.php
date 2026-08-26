<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CityRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCityRequest;
use App\Http\Requests\Admin\UpdateCityRequest;
use Inertia\Inertia;
use Sadegh19b\LaravelIranCities\Models\City;

class CityController extends Controller
{
    public function __construct(
        protected CityRepositoryInterface $cityRepository,
    ) {}

    public function index()
    {
        return Inertia::render('admin/cities/Index', [
            'cities' => $this->cityRepository->paginate(15),
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/cities/Create');
    }

    public function store(StoreCityRequest $request)
    {
        $this->cityRepository->create($request->validated());

        return redirect()->route('admin.cities.index')->with('success', 'شهر با موفقیت ثبت شد.');
    }

    public function edit(City $city)
    {
        return Inertia::render('admin/cities/Edit', [
            'city' => $city,
        ]);
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $this->cityRepository->update($city->id, $request->validated());

        return redirect()->route('admin.cities.index')->with('success', 'شهر با موفقیت بروزرسانی شد.');
    }

    public function destroy(City $city)
    {
        $this->cityRepository->delete($city->id);

        return redirect()->route('admin.cities.index')->with('success', 'شهر با موفقیت حذف شد.');
    }
}
