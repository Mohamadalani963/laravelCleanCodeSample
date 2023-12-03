<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'product_id', 'url'];

    static protected function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            Storage::delete($model->url);
        });
        static::updating(function ($model) {
            $url = $model->getOriginal('url');
            if ($model->isDirty('url')) {
                Storage::delete($url);
            }
        });
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
