<?php

namespace App\Http\Controllers;

use App\Repos\CategoryRepo;
use Illuminate\Http\Request;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\ShowCategoryResource;

class CategoryController extends Controller
{
    //
    private CategoryRepo $categoryRepo;
    public function __construct(CategoryRepo $repo)
    {
        $this->categoryRepo = $repo;
    }
    public function index(Request $request)
    {
        $filters = $request->all();
        return CategoryResource::collection($this->categoryRepo->index($filters));
    }
    public function store(CreateCategoryRequest $createCategoryRequest)
    {
        $data = $createCategoryRequest->validated();
        return $this->categoryRepo->store($data);
    }
    public function update($id, UpdateCategoryRequest $updateCategoryRequest)
    {
        $data = $updateCategoryRequest->validated();
        $this->categoryRepo->update($id, $data);
        return $this->success();
    }
    public function show($id)
    {
        return new ShowCategoryResource($this->categoryRepo->show($id));
    }
    public function delete($id)
    {
        $this->categoryRepo->delete($id);
        return $this->success();
    }
}
