<?php

namespace App\Repos;

use App\Exceptions\Errors;
use App\Models\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\VarDumper\VarDumper;

class CrudRepository extends BaseRepository
{

    public function __construct($model)
    {
        parent::__construct($model);
    }
    public function index($query, $paginated = true, $relations = null, $attr = null)
    {
        $data = $this->filter($query);
        if ($relations)
            $data = $data->with($relations);
        $data = $paginated ? $data->paginate()->appends($query) : $data->get();
        return $data;
    }
    public function store($data, $attr = null)
    {
        $record = $this->model::create($data);
        $record->refresh();
        return $record;
    }
    public function show($id, array $relations = null, $attr = null)
    {
        $this->findOrFail($id);
        $query = $this->model::where('id', $id);
        if ($relations)
            $query->with($relations);
        return $query->first();
    }
    public function update($id, array $data, $attr = null)
    {
        $record = $this->findOrFail($id);
        $record->update($data);
        return $record;
    }
    public function delete($id, $attr = null)
    {
        $record = $this->findOrFail($id);
        $record->delete();
    }
    protected function from($key, $date)
    {
        return $this->query->where("created_at", ">=", $date);
    }
    protected function to($key, $date)
    {
        return $this->query->where("created_at", "<=", $date);
    }
}
