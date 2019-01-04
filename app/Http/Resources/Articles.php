<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Articles extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);

        // to remove created at and upsated at

        // return [
        //     'id' => $this->id,
        //     'title' => $this->title,
        //     'body' => $this->body
        // ];
    }
}
