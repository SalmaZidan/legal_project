<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class IssueResource extends JsonResource
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
        
        return [
            "id" => $this->id,
            "nunmber" => $this->number,
            "year" => $this->year,
            "day" => $this->day,
            "governorate_id" => $this->governorate_id,
            "court_id" => $this->court_id,
            "authorization_number" => $this->authorization_number,
            "confirmation_number" => $this->documentation_number,
            "date" => $this->date,
            "agent_class" => $this->agent_class,
            "case_type_id" => $this->issue_type_id,
            "cost" => $this->cost,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
