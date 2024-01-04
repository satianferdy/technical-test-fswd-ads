<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductAssetsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // TODO: change this to a policy
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
                'product_id' => 'required|exists:products,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        } else {
            return [
                'product_id' => 'required|exists:products,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }
    }

    public function messages()
    {
        if (request()->isMethod('POST')) {
            return [
                'product_id.required' => 'Product ID is required',
                'product_id.exists' => 'Product ID does not exist',
                'image.*.required' => 'Image is required',
                'image.*.image' => 'Image must be an image',
                'image.*.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image.*.max' => 'Image must be less than 2048 kilobytes.',
            ];
        } else {
            return [
                'product_id.required' => 'Product ID is required',
                'product_id.exists' => 'Product ID does not exist',
            ];
        }
    }
}
