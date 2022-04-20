<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Agent;

class AgentResource extends JsonResource
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
        $agent = Agent::find($this->id);
        $cases= [];
        foreach($agent->issues as $issue){
            $data = new IssueResource($issue ,$this->language);
            array_push($cases,$data);
        }

        return [
            "id" => $this->id,
            "name" => $this->name,
            "phones" =>  AgentPhoneResource::collection($agent->phones),
            "addresses" => AgentAddressResource::collection($agent->addresses),
            "documents" => AgentDocumentResource::collection($agent->documents),
            "cases" => $cases,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
