<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterProductRequest;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    public function index(FilterProductRequest $request)
    {
        $data = $this->productService->list($request->filters());

        return view('catalog.index', $data);
    }

    public function show(Product $product)
    {
        $data = $this->productService->show($product);

        return view('catalog.show', $data);
    }
}
