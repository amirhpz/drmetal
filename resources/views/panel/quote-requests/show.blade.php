@extends('layouts.panel')

@section('title', 'جزئیات درخواست قیمت')
@section('heading', 'جزئیات درخواست قیمت')
@section('subtitle', $quoteRequest->contact_person.' / '.($quoteRequest->product?->title ?? 'محصول حذف شده'))

@section('actions')
    <x-panel.button :href="route('panel.quote-requests.index')">بازگشت به درخواست‌ها</x-panel.button>
@endsection

@section('content')
    <div class="panel-grid" style="grid-template-columns: minmax(0, 1.1fr) minmax(320px, .9fr); align-items: start;">
        <x-panel.card>
            <x-panel.section-head title="اطلاعات درخواست" />

            <div class="form-grid">
                <div class="form-field">
                    <label>نام رابط</label>
                    <input value="{{ $quoteRequest->contact_person }}" readonly>
                </div>
                <div class="form-field">
                    <label>شماره تماس</label>
                    <input value="{{ $quoteRequest->phone }}" readonly dir="ltr">
                </div>
                <div class="form-field">
                    <label>نام شرکت</label>
                    <input value="{{ $quoteRequest->company_name ?: 'ثبت نشده' }}" readonly>
                </div>
                <div class="form-field">
                    <label>ایمیل</label>
                    <input value="{{ $quoteRequest->email ?: 'ثبت نشده' }}" readonly dir="ltr">
                </div>
                <div class="form-field">
                    <label>محصول</label>
                    <input value="{{ $quoteRequest->product?->title ?? 'محصول حذف شده' }}" readonly>
                </div>
                <div class="form-field">
                    <label>مقدار مورد نیاز</label>
                    <input value="{{ $quoteRequest->quantity ?: 'ثبت نشده' }}" readonly>
                </div>
                <div class="form-field is-wide">
                    <label>توضیحات مشتری</label>
                    <textarea readonly>{{ $quoteRequest->message ?: 'توضیحی ثبت نشده است.' }}</textarea>
                </div>
            </div>
        </x-panel.card>

        <x-panel.card>
            <x-panel.section-head title="پیگیری داخلی" />

            <form method="POST" action="{{ route('panel.quote-requests.update', $quoteRequest) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-field is-wide">
                        <label for="status">وضعیت</label>
                        <select id="status" name="status" required>
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $quoteRequest->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status') <span class="error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field is-wide">
                        <label for="admin_note">یادداشت داخلی</label>
                        <textarea id="admin_note" name="admin_note" rows="6">{{ old('admin_note', $quoteRequest->admin_note) }}</textarea>
                        @error('admin_note') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <x-panel.form-actions :back="route('panel.quote-requests.index')" submit="ذخیره پیگیری" />
            </form>

            <form method="POST" action="{{ route('panel.quote-requests.destroy', $quoteRequest) }}" onsubmit="return confirm('این درخواست قیمت حذف شود؟')" style="margin-top: 10px;">
                @csrf
                @method('DELETE')
                <x-panel.button variant="danger" type="submit">حذف درخواست</x-panel.button>
            </form>
        </x-panel.card>
    </div>
@endsection
