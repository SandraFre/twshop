<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $categories = Category::query()->paginate();

        return view('categories.list', ['list' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('categories.form');
    }


    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        Category::query()->create($request->getData());

        return redirect()->route('categories.index')
            ->with('status', 'Category created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category): View
    {
        return view('categories.form', ['item'=>$category]);
    }


    public function update(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->getData());

        return redirect()->route('categories.index')
        ->with('status', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index')
        ->with('status', 'Category deleted successfully!');
    }
}
