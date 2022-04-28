<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Governorate;
use App\Models\Court;
use App\Models\IssueType;
use App\Models\Issue;

class IssueResource extends JsonResource
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
        $issue = Issue::find($this->id);
        $goverorate = Governorate::find($this->governorate_id);
        $court = Court::find($this->court_id);
        $issue_type = IssueType::find($this->issue_type_id);
        
        return [
            "id" => $this->id,
            "nunmber" => $this->number,
            "year" => $this->year,
            "day" => $this->day,
            "governorate" => isset($goverorate)? new GovernorateResource($goverorate, $this->language): '',
            "court" => isset($court)?  new CourtResource($court, $this->language): '',
            "authorization_number" => $this->authorization_number,
            "confirmation_number" => $this->documentation_number,
            "date" => $this->date,
            "agent_class" => $this->agent_class,
            "case_type" => isset($issue_type)? new IssueTypeResource($issue_type, $this->language): '' ,
            "cost" => $this->cost,
            "details" => $this->details,
            "documents" => AgentDocumentResource::collection($issue->files),
            "agents" => AgentInfoResource::collection($issue->agents, $this->language),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
