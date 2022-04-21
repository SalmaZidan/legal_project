<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Court;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Http\Resources\Api\CourtResource;


class CourtController extends Controller
{
    use HelperTrait , ApiTraits;

    public function list(Request $request){
        try {
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
            $courts = Court::paginate(15);
            $courts_data = [];
            foreach($courts as $court){
                $data = new CourtResource($court ,$lang);
                array_push($courts_data,$data);
            }
            return $this->responseJsonPaginate(200, "Successfully", $courts_data , $this->getPaginates(CourtResource::collection($courts)));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function filterByGovernorate(Request $request, $id){
        try {
            if($request->header('lang')){
                if($request->header('lang') == 'ar'){
                    $lang = 'ar';
                }else{$lang = 'en';}
            }else{
                $lang = 'ar';
            }
            $courts = Court::where('governorate_id' , $id)->paginate(15);
            $courts_data = [];
            foreach($courts as $court){
                $data = new CourtResource($court ,$lang);
                array_push($courts_data,$data);
            }
            return $this->responseJsonPaginate(200, "Successfully", $courts_data , $this->getPaginates(CourtResource::collection($courts)));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }
}
