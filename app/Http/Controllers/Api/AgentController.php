<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Http\Requests\Api\Agent\AddRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\AgentResource;
use App\Models\Agent;

class AgentController extends Controller
{
    use ApiTraits, HelperTrait;

    public function add(AddRequest $request){
        try {
            $agent = Agent::create(["name" => $request->name]);
            foreach ($request->addresses as $address) {
                $agent->addresses()->create(["address" => $address]);
            }
            foreach ($request->numbers as $number) {
                $agent->phones()->create(["phone" => $number]);
            }
            if($request->documents){
                foreach ($request->documents as $document) {
                    $file = $this->uploadImages($document, "documents/agent");
                    $agent->documents()->create(["file" => $file]);
                }
            }
            return $this->responseJson(200, "Agent Added Successfully", new AgentResource($agent));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function list(){
        try {
            $agents = Agent::paginate(15);
            return $this->responseJsonPaginate(200, "Successfully", AgentResource::collection($agents) , $this->getPaginates(AgentResource::collection($agents)));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function info($id){
        try {
            $agents = Agent::find($id);
            return $this->responseJsonPaginate(200, "Successfully", AgentResource::collection($agents) , $this->getPaginates(AgentResource::collection($agents)));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }
}
