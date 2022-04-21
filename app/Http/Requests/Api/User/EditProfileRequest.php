<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiTraits;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class EditProfileRequest extends FormRequest
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
            "name" => "nullable",
            "phone" => "nullable|unique:users,phone|min:11",
            "email" => "nullable|email|unique:users,email",
            "password" => "nullable",
            "code_status" => "nullable|in:0,1",
            "code" => "nullable",
            "image" => "nullable|file|mimes:png,jpg,svg,gif",
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
