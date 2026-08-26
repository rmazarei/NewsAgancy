<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
    ) {}

    public function index()
    {
        return Inertia::render('admin/categories/Index', [
            'categories' => $this->categoryRepository->paginate(15),
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/categories/Create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryRepository->create($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی با موفقیت ثبت شد.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('admin/categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->categoryRepository->update($category->id, $request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی با موفقیت بروزرسانی شد.');
    }

    public function destroy(Category $category)
    {
        $this->categoryRepository->delete($category->id);

        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }
}
