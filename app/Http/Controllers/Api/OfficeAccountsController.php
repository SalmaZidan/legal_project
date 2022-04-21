<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\OfficeAccounts\AddRequest;
use App\Models\OfficeAccount;
use App\Traits\ApiTraits;
use App\Traits\HelperTrait;
use App\Http\Resources\Api\OfficeAccountsResource;

class OfficeAccountsController extends Controller
{
    use HelperTrait , ApiTraits;

    public function add(AddRequest $request){
        try {
            $office_account = OfficeAccount::create($request->all());
            $office_accounts = OfficeAccount::paginate(50);
            return $this->responseJsonPaginate(200, "Added Successfully", OfficeAccountsResource::collection($office_accounts),$this->getPaginates(OfficeAccountsResource::collection($office_accounts)));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }

    public function list(){
        try {
            $office_accounts = OfficeAccount::paginate(50);
            return $this->responseJsonPaginate(200, "Successfully", OfficeAccountsResource::collection($office_accounts),$this->getPaginates(OfficeAccountsResource::collection($office_accounts)));
        } catch (Throwable $e) {
            return $this->responseJsonFailed();
        }
    }
}
