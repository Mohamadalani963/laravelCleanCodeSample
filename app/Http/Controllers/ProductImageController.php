<?php

namespace App\Http\Controllers;

use App\Repos\ProductRepo;
use App\Repos\CategoryRepo;
use Illuminate\Http\Request;
use App\Repos\ProductImageRepo;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Requests\CreateProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ShowProductResource;
use App\Http\Resources\Category\ShowCategoryResource;
use App\Http\Resources\ProductImage\ProductImageResource;
use App\Http\Resources\ProductImage\ShowProductImageResource;

class ProductImageController extends Controller
{
    //
    private ProductImageRepo $productRepo;
    public function __construct(ProductImageRepo $repo)
    {
        $this->productRepo = $repo;
    }
    public function index(Request $request)
    {
        $filters = $request->all();
        return ProductImageResource::collection($this->productRepo->index($filters));
    }
    public function store(CreateProductImageRequest $createCategoryRequest)
    {
        $data = $createCategoryRequest->validated();
        return $this->productRepo->store($data);
    }
    public function update($id, UpdateProductImageRequest $updateCategoryRequest)
    {
        $data = $updateCategoryRequest->validated();
        $this->productRepo->update($id, $data);
        return $this->success();
    }
    public function show($id)
    {
        return new ShowProductImageResource($this->productRepo->show($id));
    }
    public function delete($id)
    {
        $this->productRepo->delete($id);
        return $this->success();
    }
}
