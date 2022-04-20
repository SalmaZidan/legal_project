<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Employee\AddRequest;
use App\Http\Requests\Api\Employee\AddCaseRequest;
use App\Models\User;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Http\Resources\Api\UserResource;

class EmployeeController extends Controller
{
    use HelperTrait , ApiTraits;

    public function add(AddRequest $request){
        try {
            if($request->image){
                $image = $this->uploadImages($request->image, "images/user/profile");
            }
            $user = User::create([
                "name" => $request->name,
                "phone" => $request->phone,
                "email" => $request->email,
                "password" => $request->password,
                "image" => $image,
                "type" => 1,
            ]);
            return $this->responseJson(200, "Employee created Successfully", new UserResource($user));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function list(){
        try {
            $users = User::where('type',1)->get();
            return $this->responseJson(200, "Successfully", UserResource::collection($users));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function addCase(AddCaseRequest $request){
        try {
            $user = User::find($request->employee_id);
            $user->issues()->syncWithoutDetaching($request->case_id);
            return $this->responseJson(200, "Successfully", new UserResource($user));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }
}
