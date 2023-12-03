<?php

namespace App\Repos;

use App\Models\Product;
use App\Models\Category;

class ProductRepo extends CrudRepository
{
    public function __construct()
    {
        return parent::__construct(Product::class);
    }
    protected $filters = [];
}
