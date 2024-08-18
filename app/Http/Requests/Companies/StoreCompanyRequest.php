<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreCompanyRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:companies,email',
            'logo' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:1024',
            'website' => 'required|max:255',
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
