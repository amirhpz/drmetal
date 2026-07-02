<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteRequestStoreRequest;
use App\Mail\QuoteRequestReceived;
use App\Models\QuoteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class QuoteRequestController extends Controller
{
    public function store(QuoteRequestStoreRequest $request): RedirectResponse|JsonResponse
    {
        $quoteRequest = QuoteRequest::query()->create($request->safe()->except('website') + [
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        $quoteRequest->load('product');
        $this->sendNotification($quoteRequest);

        $message = 'درخواست قیمت شما با موفقیت ثبت شد. واحد فروش برای هماهنگی با شما تماس می‌گیرد.';

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'quote_request_id' => $quoteRequest->id,
            ]);
        }

        return back()->with('success', 'درخواست قیمت شما با موفقیت ثبت شد. واحد فروش برای هماهنگی با شما تماس می‌گیرد.');
    }

    private function sendNotification(QuoteRequest $quoteRequest): void
    {
        $recipient = config('mail.notification_to');

        if (! $recipient) {
            return;
        }

        try {
            Mail::to($recipient)->send(new QuoteRequestReceived($quoteRequest));
        } catch (\Throwable $exception) {
            Log::warning('Quote notification email failed.', ['message' => $exception->getMessage()]);
        }
    }
}
