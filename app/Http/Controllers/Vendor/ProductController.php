<?php 
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\Vendor\StoreProductRequest;
use App\Http\Requests\Vendor\UpdateProductRequest;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function create() {
        return Inertia::render('Vendor/Products/Create', [
            'categories' => Category::where('restaurant_id', auth()->user()->restaurant->id)->get(['id', 'name']),
            'category_id' => request('category_id'),
        ]);
    }

    public function store(StoreProductRequest $request) {
        Product::create($request->validated());
        return to_route('vendor.menu')->withStatus('Product created.');
    }

    public function edit(Product $product) {
        return Inertia::render('Vendor/Products/Edit', [
            'product' => $product,
            'categories' => Category::where('restaurant_id', auth()->user()->restaurant->id)->get(['id', 'name']),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product) {
        $product->update($request->validated());
        return to_route('vendor.menu')->withStatus('Product updated.');
    }

    public function destroy(Product $product) {
        $product->delete();
        return to_route('vendor.menu')->withStatus('Product deleted.');
    }
}