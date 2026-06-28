<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactPageController extends Controller
{
    public function index(): View
    {
        return view('pages.contact', [
            'contactSettings' => SiteSettings::group('contact') + SiteSettings::group('company') + SiteSettings::group('social'),
            'company' => config('company'),
            'products' => Product::query()->active()->ordered()->get(['id', 'title']),
            'metaTitle' => 'تماس با دکتر متال',
            'metaDescription' => 'اطلاعات تماس صنایع متالورژی دکتر متال، شماره تماس، وب‌سایت و آدرس دفتر و کارخانه.',
        ]);
    }

    public function store(ContactMessageRequest $request): RedirectResponse
    {
        $contactMessage = ContactMessage::query()->create($request->safe()->except('website') + [
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        $this->sendNotification($contactMessage);

        return back()->with('success', 'پیام شما با موفقیت ثبت شد. همکاران ما در اولین فرصت پیگیری خواهند کرد.');
    }

    private function sendNotification(ContactMessage $contactMessage): void
    {
        $recipient = config('mail.notification_to');

        if (! $recipient) {
            return;
        }

        try {
            Mail::to($recipient)->send(new ContactMessageReceived($contactMessage));
        } catch (\Throwable $exception) {
            Log::warning('Contact notification email failed.', ['message' => $exception->getMessage()]);
        }
    }
}
