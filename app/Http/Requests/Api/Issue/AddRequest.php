<?php

namespace App\Http\Requests\Api\Issue;

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
            "number" => "required",
            "year" => "required",
            "day" => "required|in:0,1,2,3,4,5,6",
            "governorate_id" => "required|exists:governorates,id",
            "court_id" => "required|exists:courts,id",
            "authorization_number" => "required",
            "confirmation_number" => "required",
            "date" => "required|date",
            "agent_class" => "required|in:0,1",
            "case_type_id" => "required|exists:issue_types,id",
            "cost" => "required",
            "details" => "required",
            "agents" => "array|required|min:1",
            "documents" => "array",
            "documents.*" => "file",
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
