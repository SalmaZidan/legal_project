<?php

namespace App\Http\Requests\Api\IssueAccounts;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiTraits;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class AddRequest extends FormRequest
{
    use ApiTraits;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "case_id" => "required|exists:issues,id",
            "case_account_type_id" => "required|exists:issue_account_types,id",
            "price" => "required",
            "note" => "required",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $er = [];
        $errors = $this->validator->errors();
        foreach($errors->all() as $error){
            array_push($er, $error);
        }
        throw new HttpResponseException(
            $this->responseValidationJsonFailed($er)
        );
    }
}
