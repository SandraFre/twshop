<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::query()->create($request->getData());

        if ($image = $request->getImage()) {
            $product->addMedia($image)->toMediaCollection('product_images');
        }

        $product->categories()->sync($request->getCatIds());

        return redirect()->route('products.index')
            ->with('status', 'Product created!');
    }

}
