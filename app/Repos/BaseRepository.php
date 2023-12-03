<?php

namespace App\Repos;

use App\Exceptions\Errors;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Translation\CatalogueMetadataAwareInterface;
use Symfony\Component\VarDumper\VarDumper;

class BaseRepository
{
    protected Builder $query;
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
        $this->query = $model::query();
    }
    protected $filters = [];


    public function filter(array $attributes): Builder
    {
        $this->resetQuery();
        foreach ($attributes as $key => $value) {
            if (array_key_exists($key, $this->filters))
                call_user_func([$this, $this->filters[$key]], $key, $value);
        }
        return $this->query;
    }

    protected function like(string $key, $value): void
    {
        $this->query->where($key, 'like', '%' . $value . '%');
    }

    protected function equal(string $key, $value): void
    {
        $this->query->where($key, $value);
    }

    protected function greaterThan(string $key, $value): void
    {
        $this->query->where($key, '>', $value);
    }

    protected function lessThan(string $key, $value): void
    {
        $this->query->where($key, '<', $value);
    }

    protected function between(string $key, $value): void
    {
        if (is_array($value) && count($value) === 2) {
            $this->query->whereBetween($key, $value);
        }
    }
    protected function ordering($key, $value)
    {
        $this->query->orderBy('created_at', $value);
    }
    protected function json(string $key, $value): void
    {
        $this->query->whereJsonContains($key, $value);
    }

    protected function resetQuery(): void
    {
        $this->query = $this->model::query();
    }

    protected function transaction(callable $call_back, callable $onError = null)
    {
        try {
            DB::beginTransaction();
            $var = $call_back();
            DB::commit();
            return $var;
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            Log::error($e->getLine());
            Log::error($e->getFile());
            if ($onError != null) $onError($e);
        }
    }

    public function findOrFail($id, $onFail = null)
    {
        $record = $this->model::find($id);
        if (!$record) {
            if ($onFail != null) $onFail();
            Errors::ResourceNotFound();
        }
        return $record;
    }
}


// $this->query->whereHas('products.offers', function ($q) use ($value) {
//     $q->where('id' , $value)
//  });
