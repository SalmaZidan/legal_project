<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Http\Resources\Api\UserResource;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\ConfirmCodeRequest;
use App\Http\Requests\Api\Auth\ResetRequest;
use App\Http\Requests\Api\Auth\PasswordChangeRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiTraits, HelperTrait;

    public function login(LoginRequest $request){
        try {
            $auth = Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]);
            $auth_user = User::where("email", $request->email)->first();
            $apiToke  = $auth_user->createToken('auth_token')->accessToken;

            if (!Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return $this->responseJsonFailed(422, 'user password is incorrect');
            }else{
                $auth_user->api_token = $apiToke;
                return $this->responseJson(200, "User Login Successfully", new UserResource($auth_user));
            }
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function confirmCode(ConfirmCodeRequest $request){
        try {
            $user = Auth::user();
            if($user->code_status){
                if($user->code == $request->code){
                    $user->api_token = $request->bearerToken();
                    return $this->responseJson(200, "User Login Successfully", new UserResource($user));
                }else{
                    return $this->responseJsonFailed(422, 'user code is incorrect');
                }
            }else{
                return $this->responseJsonFailed(422, 'code status not activated');
            }
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function resetPassword(ResetRequest $request){
        try {
            $reset_code = Str::random( 8 );
            $user = User::where('email',$request->email)->first();
            $user->reset_password=$reset_code;
            $user->save();
            $user = User::where('email',$request->email)->first()->toArray();

            Mail::send('reset_email_form', array('user' => $user , 'reset_code' => $reset_code), function($message) use($user){
                $message->to($user['email'])->subject('Password Reset Code');
                $message->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
            });

            return $this->responseJsonWithoutData();
            
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function resetCode(ResetRequest $request){
        try {
            $reset_code = Str::random( 8 );
            $user = User::where('email',$request->email)->first();
            $user->reset_code=$reset_code;
            $user->save();
            $user = User::where('email',$request->email)->first()->toArray();

            Mail::send('reset_email_form', array('user' => $user , 'reset_code' => $reset_code), function($message) use($user){
                $message->to($user['email'])->subject('Code Reset Code');
                $message->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
            });

            return $this->responseJsonWithoutData();
            
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function changePassword(PasswordChangeRequest $request){
        // try {
            $user = User::where('email',$request->email)->first();
            if($user->reset_password == $request->code){
                $user->password=$request->password;
                $user->save();
                return $this->responseJsonWithoutData();
            }else{
                return $this->responseJsonFailed(422, 'reset code is incorect');
            }
            
        // } catch (Throwable $e) {
        //     return $this->responseJsonFailed();
        // }
    }

    public function changeCode(PasswordChangeRequest $request){
        try {
            $user = User::where('email',$request->email)->first();
            if($user->reset_code == $request->code){
                $user->code=$request->password;
                $user->save();
                return $this->responseJsonWithoutData();
            }else{
                return $this->responseJsonFailed(422, 'reset code is incorect');
            }
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }
}
