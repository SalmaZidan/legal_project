<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Enemy;

class EnemyResource extends JsonResource
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
        $enemy = Enemy::find($this->id);

        return [
            "id" => $this->id,
            "name" => $this->name,
            "phones" =>  AgentPhoneResource::collection($enemy->phones),
            "addresses" => AgentAddressResource::collection($enemy->addresses),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
