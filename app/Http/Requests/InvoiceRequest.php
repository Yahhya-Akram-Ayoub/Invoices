<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'invoice_number' => 'required|max:255',
            'invoice_date' => 'required|max:255',
            'due_date' => 'required|max:255',
            'branch' => 'required|max:255',
            'section' => 'required|max:255',
            'amount_collection' => 'required|max:255',
            'amount_commission' => 'required|max:255',
            'discount' => 'required|max:255',
            'rate_vat' => 'required|max:255',
            'value_vat' => 'required|max:255',
            'total_amount' => 'required|max:255',
            'note' =>'max:255',
        ];
    }


    public function messages()
    {
        return [
            'required' => 'هناك احد الحقول يجب ان لا يكون فارغ ',
            'max:255' => 'اقصى حد لطول النص 255 حرف ',
        ];
    }
}
