<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\DTO\Base\CollectionDTO;
use App\DTO\Base\PaginateLengthAwareDTO;
use App\DTO\CategoryDTO;
use App\DTO\ProductDTO;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::query()
            ->orderBy('title')
            ->get();

        $categoriesDTO = new CollectionDTO();

        foreach ($categories as $category) {
            $categoriesDTO->pushItem(new CategoryDTO($category));
        }

        return response()->json($categoriesDTO);
    }

    public function products(string $slug): JsonResponse
    {
        $products = Product::query()
            ->with('categories')
            ->whereHas('categories', function (Builder $q) use ($slug) {
                $q->where('slug', '=', $slug);
            })
            ->paginate();

            $paginateDTO = new PaginateLengthAwareDTO($products);
            $productsDTO = new CollectionDTO();

            foreach ($products as $product) {
                $productsDTO->pushItem(new ProductDTO($product));
            }

            $paginateDTO->setData($productsDTO);

        return response()->json($products);
    }
}
