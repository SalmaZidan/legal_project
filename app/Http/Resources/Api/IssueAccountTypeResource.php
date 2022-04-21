<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class IssueAccountTypeResource extends JsonResource
{
    public function __construct($resource, $language)
    {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->language = $language;
        
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $name = "name_".$this->language;

        return [
            "id" => $this->id,
            "name" => $this->$name,
        ];
    }
}
