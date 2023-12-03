<?php

namespace App\Repos;

use App\Models\Category;

class CategoryRepo extends CrudRepository
{
    public function __construct()
    {
        return parent::__construct(Category::class);
    }
    protected $filters = [];
}
