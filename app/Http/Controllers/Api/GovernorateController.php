<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Governorate;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Http\Resources\Api\GovernorateResource;

class GovernorateController extends Controller
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
            $governorates = Governorate::all();
            $governorates_data = [];
            foreach($governorates as $governorate){
                $data = new GovernorateResource($governorate ,$lang);
                array_push($governorates_data,$data);
            }
            return $this->responseJson(200, "Successfully", $governorates_data);
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }
}
