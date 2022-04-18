<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Agent;

class AgentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */


    public function toArray($request)
    {
        $agent = Agent::find($this->id);

        return [
            "id" => $this->id,
            "name" => $this->name,
            "phones" =>  AgentPhoneResource::collection($agent->phones),
            "addresses" => AgentAddressResource::collection($agent->addresses),
            "documents" => AgentDocumentResource::collection($agent->documents),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
