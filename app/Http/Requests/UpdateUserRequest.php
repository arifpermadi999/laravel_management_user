<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_fullname' => 'required',
            'user_email' => 'required|email',
            'password' => 'required_with:password_confirmation|same:password_confirmation'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $message = "";
        foreach ($validator->errors()->toArray() as $errors) {
            foreach ($errors as $error) {
                $message .= $error . "\n";
            }
        }

        // Throw an HttpResponseException with a custom response
        throw new HttpResponseException(response()->json(['success' => false,'message' => $message], 200));
    }
    
}
