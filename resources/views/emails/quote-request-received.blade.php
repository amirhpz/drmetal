<div dir="rtl" style="font-family: Tahoma, Arial, sans-serif; line-height: 1.9;">
    <h1>درخواست قیمت جدید</h1>
    <p><strong>شرکت:</strong> {{ $quoteRequest->company_name ?: 'ثبت نشده' }}</p>
    <p><strong>نام رابط:</strong> {{ $quoteRequest->contact_person }}</p>
    <p><strong>تلفن:</strong> {{ $quoteRequest->phone }}</p>
    <p><strong>ایمیل:</strong> {{ $quoteRequest->email ?: 'ثبت نشده' }}</p>
    <p><strong>محصول:</strong> {{ $quoteRequest->product?->title ?: 'انتخاب نشده' }}</p>
    <p><strong>مقدار:</strong> {{ $quoteRequest->quantity ?: 'ثبت نشده' }}</p>
    <p><strong>توضیحات:</strong></p>
    <p>{{ $quoteRequest->message ?: 'ثبت نشده' }}</p>
</div>
