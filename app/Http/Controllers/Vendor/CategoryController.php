<?php 

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Vendor\StoreCategoryRequest;
use App\Http\Requests\Vendor\UpdateCategoryRequest;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function create() {
        return Inertia::render('Vendor/Categories/Create');
    }

    public function store(StoreCategoryRequest $request) {
        auth()->user()->restaurant->categories()->create($request->validated());
        return to_route('vendor.menu')->withStatus('Category created.');
    }

    public function edit(Category $category) {
        return Inertia::render('Vendor/Categories/Edit', ['category' => $category]);
    }

    public function update(UpdateCategoryRequest $request, Category $category) {
        $category->update($request->validated());
        return to_route('vendor.menu')->withStatus('Category updated.');
    }

    public function destroy(Category $category) {
        $category->delete();
        return to_route('vendor.menu')->withStatus('Category deleted.');
    }
}