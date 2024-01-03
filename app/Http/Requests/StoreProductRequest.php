<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // set to true if you want to authorize this request
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
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|unique:products,name',
                'slug' => 'required|unique:products,slug',
                'price' => 'required|numeric',
            ];
        } else {
            return [
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|unique:products,name,',
                'slug' => 'required|unique:products,slug,',
                'price' => 'required|numeric',
            ];
        }
    }

    public function messages()
    {
        if (request()->isMethod('POST')) {
            return [
                'category_id.required' => 'Category is required',
                'category_id.exists' => 'Category does not exist',
                'name.required' => 'Product name is required',
                'name.unique' => 'Product name already exists',
                'slug.required' => 'Product slug is required',
                'slug.unique' => 'Product slug already exists',
                'price.required' => 'Product price is required',
                'price.numeric' => 'Product price must be numeric',
            ];
        } else {
            return [
                'category_id.required' => 'Category is required',
                'category_id.exists' => 'Category does not exist',
                'name.required' => 'Product name is required',
                'name.unique' => 'Product name already exists',
                'slug.required' => 'Product slug is required',
                'slug.unique' => 'Product slug already exists',
                'price.required' => 'Product price is required',
                'price.numeric' => 'Product price must be numeric',
            ];
        }
    }
}
