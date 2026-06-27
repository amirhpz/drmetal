<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:190'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'website' => ['nullable', 'size:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'لطفا نام و نام خانوادگی را وارد کنید.',
            'phone.required' => 'لطفا شماره تماس را وارد کنید.',
            'email.email' => 'فرمت ایمیل معتبر نیست.',
            'message.required' => 'لطفا متن پیام را وارد کنید.',
            'message.min' => 'متن پیام باید حداقل ۱۰ کاراکتر باشد.',
            'website.size' => 'درخواست معتبر نیست.',
            '*.max' => 'مقدار وارد شده بیش از حد مجاز است.',
        ];
    }
}
