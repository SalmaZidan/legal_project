<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\IssueAccounts\AddRequest;
use App\Models\IssueAccount;
use App\Models\Issue;
use App\Models\Agent;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Http\Resources\Api\IssueAccountsResource;
use App\Http\Resources\Api\IssueResource;

class IssueAccountsController extends Controller
{
    use HelperTrait , ApiTraits;

    public function add(AddRequest $request){
        try {
            $issue_account = IssueAccount::create([
                'issue_id' => $request->case_id,
                'issue_account_type_id' =>$request->case_account_type_id,
                'price' =>$request->price,
                'note' =>$request->note,
            ]);
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
            $issue_accounts = IssueAccount::where('issue_id',$request->case_id )->paginate(50);
            $data = [];
            foreach($issue_accounts as $issue_account){
                $single_data = new IssueAccountsResource($issue_account ,$lang);
                array_push($data,$single_data);
            }
            return $this->responseJsonPaginate(200, "Added Successfully", $data,$this->getPaginates(IssueAccountsResource::collection($issue_accounts)));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function list(Request $request){
        try {
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
            $issues = Issue::paginate(20);
            $data = [];
            foreach($issues as $issue){
                $dept= 0 ;
                $expenses = 0;
                foreach($issue->accounts as $r){
                    if($r->type->type == 0){
                        $dept= $dept + $r->price;
                    }if($r->type->type == 1){
                        $expenses= $expenses - $r->price;
                    }
                }
                $single_data = [
                    'id' => $issue->id,
                    'agent'=>$issue->agents->pluck('name'),
                    'date'=>$issue->date,
                    'type'=> $issue->type['name_'.$lang],
                    'cost'=>$issue->cost,
                    'expenses'=>$expenses,
                    'dept'=>$dept,
                    // 'test'=>$issue->accounts,
                ];
                array_push($data,$single_data);
            }
            return $this->responseJsonPaginate(200, "Successfully", $data, $this->getPaginates(IssueResource::collection($issues)));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function singleIssueList(Request $request, $id){
        try {
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
            $issue = Issue::find($id);
            $data = [];
            $accounts = [];
            // foreach($issues as $issue){
                $dept= 0 ;
                $expenses = 0;
                foreach($issue->accounts as $r){
                    $single_data1 = new IssueAccountsResource($r ,$lang);
                    array_push($accounts,$single_data1);
                    if($r->type->type == 0){
                        $dept= $dept + $r->price;
                    }if($r->type->type == 1){
                        $expenses= $expenses - $r->price;
                    }
                }
                $single_data = [
                    'id' => $issue->id,
                    'agent'=>$issue->agents->pluck('name'),
                    'date'=>$issue->date,
                    'type'=> $issue->type['name_'.$lang],
                    'cost'=>$issue->cost,
                    'expenses'=>$expenses,
                    'dept'=>$dept,
                    'accounts'=>$accounts,
                ];
                // array_push($data,$single_data);
            // }
            return $this->responseJson(200, "Successfully", $single_data);
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }


    public function agentList(Request $request,$id){
        try {
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
            $issues = Agent::find($id)->issues;
            $data = [];
            foreach($issues as $issue){
                $dept= 0 ;
                $expenses = 0;
                foreach($issue->accounts as $r){
                    if($r->type->type == 0){
                        $dept= $dept + $r->price;
                    }if($r->type->type == 1){
                        $expenses= $expenses - $r->price;
                    }
                }
                $single_data = [
                    'id' => $issue->id,
                    'agent'=>$issue->agents->pluck('name'),
                    'date'=>$issue->date,
                    'type'=> $issue->type['name_'.$lang],
                    'cost'=>$issue->cost,
                    'expenses'=>$expenses,
                    'dept'=>$dept,
                ];
                array_push($data,$single_data);
            }
            return $this->responseJson(200, "Successfully", $data);
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }
}
