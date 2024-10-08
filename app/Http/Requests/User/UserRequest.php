<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' =>  'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' =>  'Email',
            'password' => 'Şifre',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
          $errors = $validator->errors()->all();
          $response = response()->json([
            'messages' => $errors
          ], 422);

          throw new ValidationException($validator, $response);
    }
}
