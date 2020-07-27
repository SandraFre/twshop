<?php

namespace App\Http\Controllers\API;

use App\DTO\Base\CollectionDTO;
use App\DTO\Base\PaginateLengthAwareDTO;
use App\DTO\ProductDTO;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::query()
            ->with('categories')
            ->orderByDesc('created_at')
            ->paginate();

        $paginateDTO = new PaginateLengthAwareDTO($products);
        $productsDTO = new CollectionDTO();

        foreach ($products as $product) {
            $productsDTO->pushItem(new ProductDTO($product));
        }

        $paginateDTO->setData($productsDTO);

        return response()->json($paginateDTO);
    }

    public function show(string $slug): JsonResponse
    {
        $product = Product::query()
            ->where('slug', '=', $slug)
            ->firstOrFail();

        $productDTO = new ProductDTO($product);

        return response()->json($productDTO);
    }
}
