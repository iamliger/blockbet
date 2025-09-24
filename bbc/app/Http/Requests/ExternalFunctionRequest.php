<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ExternalFunctionRequest extends FormRequest
{
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
            'email'=>'required|email|exists:users',
            'password'=>'required|string|min:1|max:16'            
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {

        $response = new JsonResponse(['returnCode'=>0,'errors'=>$validator->errors()],422);

        throw (new \Illuminate\Validation\ValidationException($validator,$response));
    }
}
