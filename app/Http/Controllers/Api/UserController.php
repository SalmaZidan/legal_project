<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Api\User\EditProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Http\Resources\Api\UserResource;

class UserController extends Controller
{
    use ApiTraits, HelperTrait;
    public function editProfile(EditProfileRequest $request){
        $user = Auth::user();
        if($request->image){
            if($user->image){
                if (file_exists($user->image)){
                    unlink($user->image);
                }
            }
            $image = $this->uploadImages($request->image, "images/user/profile");
            $user->update(['image' => $image]);
        }
        $user->update($request->except('image'));
        return $this->responseJson(200, "Profile Updated Successfully", new UserResource($user));

    }
}
