<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
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
            "name" => $this->name,
            "phone" => $this->phone,
            "email" => $this->email,
            "gender" => ($this->gender == 0) ? "male" : "female",
            "code_status" => ($this->code_status) ? "1" : "0",
            "image"=>isset($this->image) ? env('APP_URL').'/public/'.$this->image : '',
            "token" => isset($this->api_token) ? $this->api_token : '',
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
