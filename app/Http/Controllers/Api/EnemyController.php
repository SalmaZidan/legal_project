<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Http\Requests\Api\Enemy\AddRequest;
use App\Models\Enemy;
use App\Http\Resources\Api\EnemyResource;

class EnemyController extends Controller
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
            $enemy = Enemy::create([
                "name" => $request->name,
                "issue_id" => $request->case_id
            ]);
            foreach ($request->addresses as $address) {
                $enemy->addresses()->create(["address" => $address]);
            }
            foreach ($request->numbers as $number) {
                $enemy->phones()->create(["phone" => $number]);
            }
            return $this->responseJson(200, "enemy Added Successfully", new EnemyResource($enemy, $lang));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

}
