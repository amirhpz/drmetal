<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequestStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'company_name' => ['nullable', 'string', 'max:160'],
            'contact_person' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:190'],
            'quantity' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:5000'],
            'website' => ['nullable', 'size:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.exists' => 'محصول انتخاب‌شده معتبر نیست.',
            'contact_person.required' => 'لطفا نام رابط را وارد کنید.',
            'phone.required' => 'لطفا شماره تماس را وارد کنید.',
            'email.email' => 'فرمت ایمیل معتبر نیست.',
            'website.size' => 'درخواست معتبر نیست.',
            '*.max' => 'مقدار وارد شده بیش از حد مجاز است.',
        ];
    }
}
