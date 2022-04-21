<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\IssueAccountType;

class IssueAccountsResource extends JsonResource
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
        $issueType = IssueAccountType::find($this->issue_account_type_id);

        return [
            "id" => $this->id,
            "type" => new IssueAccountTypeResource($issueType, $this->language),
            "price" => $this->price,
            "note" => $this->note,
        ];
    }
}
