<?php

namespace App\Repos;

use App\Models\Category;

class CategoryRepo extends CrudRepository
{
    public function __construct()
    {
        return parent::__construct(Category::class);
    }
    protected $filters = [
        'id' => 'equal',
        'name' => 'like',
        'parent_id' => 'equal'
    ];
    public function store($data, $attr = null)
    {
        if (array_key_exists('file', $data))
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
