<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Models\Issue;
use App\Http\Requests\Api\Issue\AddRequest;
use App\Http\Resources\Api\IssueResource;

class IssueController extends Controller
{
    use ApiTraits, HelperTrait;

    public function add(AddRequest $request){
        try {
            $issue = Issue::create([
                'number' => $request->number,
                'year' => $request->year,
                'day' =>$request->day,
                'governorate_id' =>$request->governorate_id,
                'court_id' =>$request->court_id,
                'authorization_number' =>$request->authorization_number,
                'documentation_number' =>$request->confirmation_number ,
                'date' =>$request->date ,
                'agent_class' =>$request->agent_class ,
                'issue_type_id' =>$request->case_type_id ,
                'cost' =>$request->cost ,
            ]);
            return $this->responseJson(200, "Case Added Successfully", new IssueResource($issue,'en'));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }
    
}
