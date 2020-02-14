<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id' => $this->id,
            'product_category'=> new CategoryResource($this->category),
            'product_tags'=>TagResource::collection($this->tags),
            'product_name' => $this->title,
            'product_desc' =>$this->description,
            'product_unit' => new UnitResource($this->hasUnit),
            'product_price' =>$this->price,
            'product_total' =>$this->total,
            'product_discount' =>$this->discount,
            'product_images' => ImageResource::collection($this->images),
            'product_reviews' =>ReviewResource::collection($this->reviews),
            'product_options' =>$this->jsonOptions(),


        ];
    }
}
