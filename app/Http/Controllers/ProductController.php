<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductStoreRequest;
use App\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $products = Product::query()->paginate();

        return view('products.list', ['list' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::query()
            ->pluck('title', 'id');

        return view('products.form', ['categories' => $categories]);
    }

   
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $product = Product::query()->create($request->getData());

        if ($image = $request->getImage()) {
            $product->addMedia($image)->toMediaCollection('product_images');
        }

        $product->categories()->sync($request->getCatIds());

        return redirect()->route('products.index')
            ->with('status', 'Product created successfully!');
    }

}
