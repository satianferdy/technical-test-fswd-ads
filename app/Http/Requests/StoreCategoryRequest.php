<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
        if (request()->isMethod('POST')) {
            return [
                'name' => 'required|unique:categories,name',
            ];
        } else {
            return [
                'name' => 'required|unique:categories,name,',
            ];
        }
    }

    public function messages()
    {
        if (request()->isMethod('POST')) {
            return [
                'name.required' => 'Category name is required',
                'name.unique' => 'Category name already exists',
            ];
        } else {
            return [
                'name.required' => 'Category name is required',
                'name.unique' => 'Category name already exists',
            ];
        }
    }
}
