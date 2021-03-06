<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'review_id' => $this->id,
            'review_user' => new UserResource($this->customer),
            'review_stars' => $this->stars,
            'review_content' => $this->review
        ];
    }
}
