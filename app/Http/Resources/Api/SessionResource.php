<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Issue;
use App\Models\Session;

class SessionResource extends JsonResource
{
    public function __construct($resource, $language)
    {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->language = $language;
        if($language){
            $this->language = $language;
        }else{
            $this->language = $resource;
        }
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $session = Session::find($this->id);
        $issue = Issue::find($this->issue_id);

        return [
            "id" => $this->id,
            "date" => $this->date,
            "judgment" => $this->judgment,
            "details" => $this->details,
            "documents" => AgentDocumentResource::collection($session->files),
        ];
    }
}
