<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Governorate;

class CourtResource extends JsonResource
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
        $address = "address_".$this->language;
        $goverorate = Governorate::find($this->governorate_id);
        
        return [
            "id" => $this->id,
            "name" => $this->$name,
            "address" => $this->$address,
            "link" => $this->link,
            "governorate" => new GovernorateResource($goverorate, $this->language),

        ];
    }
}
