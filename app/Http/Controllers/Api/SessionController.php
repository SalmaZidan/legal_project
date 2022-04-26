<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Http\Requests\Api\Session\AddRequest;
use App\Models\Session;
use App\Http\Resources\Api\SessionResource;


class SessionController extends Controller
{
    use HelperTrait , ApiTraits;

    public function add(AddRequest $request){
        try {
            $session = Session::create([
                'issue_id' => $request->case_id,
                'judgment' =>$request->judgment,
                'date' =>$request->date,
                'details'=> $request->details,
            ]);
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
            if($request->documents){
                foreach ($request->documents as $single_file) {
                    $file = $this->uploadImages($single_file, "documents/session");
                    $session->files()->create(["file" => $file]);
                }
            }
            return $this->responseJson(200, "Added Successfully", new SessionResource($session, $lang));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function list(Request $request, $id){
        try {
            $sessions = Session::where('issue_id', $id)->paginate(20);
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
            $data= [];
            foreach($sessions as $session){
                $single_session = new SessionResource($session ,$lang);
                array_push($data,$single_session);
            }
            return $this->responseJsonPaginate(200, "Successfully", $data,  $this->getPaginates(SessionResource::collection($sessions)));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function info(Request $request, $id){
        try {
            $session = Session::find($id);
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
            return $this->responseJson(200, "Successfully",new SessionResource($session ,$lang));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }
}
