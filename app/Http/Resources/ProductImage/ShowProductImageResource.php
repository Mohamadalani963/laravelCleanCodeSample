<?php

namespace App\Http\Resources\ProductImage;

use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProductImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'product' => new ProductResource($this->product),
            'url' => url('/') . '/storage/' . substr($this->url, 7)
        ];
    }
}
