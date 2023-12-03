<?php

namespace App\Http\Controllers;

use App\Repos\ProductRepo;
use App\Repos\CategoryRepo;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ShowProductResource;
use App\Http\Resources\Category\ShowCategoryResource;

class ProductController extends Controller
{
    //
    private ProductRepo $productRepo;
    public function __construct(ProductRepo $repo)
    {
        $this->productRepo = $repo;
    }
    public function index(Request $request)
    {
        $filters = $request->all();
        return ProductResource::collection($this->productRepo->index($filters));
    }
    public function store(CreateProductRequest $createCategoryRequest)
    {
        $data = $createCategoryRequest->validated();
        return $this->productRepo->store($data);
    }
    public function update($id, UpdateProductRequest $updateCategoryRequest)
    {
        $data = $updateCategoryRequest->validated();
        $this->productRepo->update($id, $data);
        return $this->success();
    }
    public function show($id)
    {
        return new ShowProductResource($this->productRepo->show($id));
    }
    public function delete($id)
    {
        $this->productRepo->delete($id);
        return $this->success();
    }
}
