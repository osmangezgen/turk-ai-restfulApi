<?php

namespace App\Http\Requests\Employees;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class StoreEmployeesRequest extends FormRequest
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
            'company_id' => 'required|integer|exists:companies,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email',
            'phone' => 'required|string|max:20',
        ];
    }

    public function attributes(): array
    {
        return [
            'company_id' => 'Şirket',
            'first_name' => 'Ad',
            'last_name' => 'Soyad',
            'email' => 'Email',
            'phone' => 'Telefon',
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
