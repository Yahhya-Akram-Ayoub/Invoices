<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name' =>'required|max:255',
            'description' => 'required|max:255',
        ];
    }


    /**
 * Get the error messages for the defined validation rules.
 *
 * @return array
 */
public function messages()
{
    return [
        'product_name.required' => 'يجب عليك اضافة اسم المنتج ',
        'description.required' => 'يجب عليك اضافة وصف للمنتج ',
    ];
}
}
