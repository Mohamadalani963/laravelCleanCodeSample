<?php

namespace App\Repos;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;

class ProductImageRepo extends CrudRepository
{
    public function __construct()
    {
        return parent::__construct(ProductImage::class);
    }
    protected $filters = [];
    public function store($data, $attr = null)
    {
        $data['url'] = $data['file']->store('public/images');
        return parent::store($data);
    }
    public function update($id, $data, $attr = null)
    {
        if (array_key_exists('file', $data))
            $data['url'] = $data['file']->store('public/images');
        return parent::update($id, $data);
    }
}
