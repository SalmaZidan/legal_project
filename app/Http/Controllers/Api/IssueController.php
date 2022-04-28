<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Models\Issue;
use App\Http\Requests\Api\Issue\AddRequest;
use App\Http\Resources\Api\IssueResource;
use App\Http\Resources\Api\IssueInfoResource;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    use ApiTraits, HelperTrait;

    public function add(AddRequest $request){
        try {
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
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
                'details' =>$request->details ,
            ]);
            $issue->agents()->attach($request->agents);
            if($request->documents){
                foreach ($request->documents as $single_file) {
                    $file = $this->uploadImages($single_file, "documents/issue");
                    $issue->files()->create(["file" => $file]);
                }
            }
            return $this->responseJson(200, "Case Added Successfully", new IssueResource($issue, $lang));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function list(Request $request){
        try {
            $user = Auth::user();
            if($user->type == 0){
                $issues = Issue::paginate(20);
            }else{
                $issues = $user->issues()->paginate(20);
            }
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
            $data= [];
            foreach($issues as $issue){
                $single_issue = new IssueResource($issue ,$lang);
                array_push($data,$single_issue);
            }
            return $this->responseJsonPaginate(200, "Successfully", $data,  $this->getPaginates(IssueResource::collection($issues)));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function info(Request $request, $id){
        try {
            $issue = Issue::find($id);
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
            return $this->responseJson(200, "Successfully", new IssueInfoResource($issue ,$lang));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }
    
}
