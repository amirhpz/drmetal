<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    public function index(Request $request): View
    {
        $quoteRequests = QuoteRequest::query()
            ->with('product')
            ->when($request->filled('q'), function ($query) use ($request): void {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('contact_person', 'like', '%'.$search.'%')
                        ->orWhere('company_name', 'like', '%'.$search.'%')
                        ->orWhere('phone', 'like', '%'.$search.'%')
                        ->orWhereHas('product', fn ($query) => $query->where('title', 'like', '%'.$search.'%'));
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('panel.quote-requests.index', [
            'quoteRequests' => $quoteRequests,
            'statuses' => $this->statuses(),
            'filters' => [
                'q' => $request->string('q')->toString(),
                'status' => $request->string('status')->toString(),
            ],
        ]);
    }

    public function show(QuoteRequest $quoteRequest): View
    {
        return view('panel.quote-requests.show', [
            'quoteRequest' => $quoteRequest->load('product'),
            'statuses' => $this->statuses(),
        ]);
    }

    public function update(Request $request, QuoteRequest $quoteRequest): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys($this->statuses()))],
            'admin_note' => ['nullable', 'string', 'max:5000'],
        ], [
            'status.required' => 'وضعیت درخواست را انتخاب کنید.',
            'status.in' => 'وضعیت انتخاب‌شده معتبر نیست.',
            'admin_note.max' => 'یادداشت داخلی بیش از حد مجاز است.',
        ]);

        $quoteRequest->update($data);

        return redirect()
            ->route('panel.quote-requests.show', $quoteRequest)
            ->with('success', 'درخواست قیمت به‌روزرسانی شد.');
    }

    public function destroy(QuoteRequest $quoteRequest): RedirectResponse
    {
        $quoteRequest->delete();

        return redirect()
            ->route('panel.quote-requests.index')
            ->with('success', 'درخواست قیمت حذف شد.');
    }

    /**
     * @return array<string, string>
     */
    private function statuses(): array
    {
        return QuoteRequest::STATUSES;
    }
}
