<div dir="rtl" style="font-family: Tahoma, Arial, sans-serif; line-height: 1.9;">
    <h1>پیام جدید از فرم تماس</h1>
    <p><strong>نام:</strong> {{ $contactMessage->full_name }}</p>
    <p><strong>تلفن:</strong> {{ $contactMessage->phone }}</p>
    <p><strong>ایمیل:</strong> {{ $contactMessage->email ?: 'ثبت نشده' }}</p>
    <p><strong>موضوع:</strong> {{ $contactMessage->subject ?: 'بدون موضوع' }}</p>
    <p><strong>پیام:</strong></p>
    <p>{{ $contactMessage->message }}</p>
</div>
