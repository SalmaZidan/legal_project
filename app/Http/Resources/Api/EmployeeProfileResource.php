<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;


class EmployeeProfileResource extends JsonResource
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
        $user = User::find($this->id);
        $cases= [];
        foreach($user->issues as $issue){
            $data = new IssueResource($issue ,$this->language);
            array_push($cases,$data);
        }

        return [
            "id" => $this->id,
            "name" => $this->name,
            "phone" => $this->phone,
            "email" => $this->email,
            "gender" => ($this->gender == 0) ? "male" : "female",
            "type" => $this->type,
            "code_status" => ($this->code_status) ? "1" : "0",
            "image"=>isset($this->image) ? env('APP_URL').'/public/'.$this->image : '',
            "cases" => $cases,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
