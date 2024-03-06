<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
            'user_email' => 'required|email',
            'password' => 'required|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
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
