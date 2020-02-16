<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'street_name' => $this->street_name,
            'street_number' => $this->street_number,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'post_code' => $this->post_code
        ];
    }
}
