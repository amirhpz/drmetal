<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $clients = Client::query()
            ->when($request->filled('q'), function ($query) use ($request): void {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('english_name', 'like', '%'.$search.'%')
                        ->orWhere('industry', 'like', '%'.$search.'%');
                });
            })
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('panel.clients.index', [
            'clients' => $clients,
            'filters' => [
                'q' => $request->string('q')->toString(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('panel.clients.create', [
            'client' => new Client([
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 0,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->rejectFailedUpload($request);

        $data = $this->validatedData($request);
        $this->applyUploadedLogo($request, $data);

        Client::query()->create($data);

        return redirect()
            ->route('panel.clients.index')
            ->with('success', 'مشتری ایجاد شد.');
    }

    public function edit(Client $client): View
    {
        return view('panel.clients.edit', [
            'client' => $client,
        ]);
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $this->rejectFailedUpload($request);

        $data = $this->validatedData($request);
        $this->applyUploadedLogo($request, $data, $client);

        $client->update($data);

        return redirect()
            ->route('panel.clients.index')
            ->with('success', 'مشتری به‌روزرسانی شد.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        if ($client->logo) {
            $this->deleteStoredPublicAsset($client->logo);
        }

        $client->delete();

        return redirect()
            ->route('panel.clients.index')
            ->with('success', 'مشتری حذف شد.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'english_name' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'logo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_logo' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'نام مشتری را وارد کنید.',
            'website.url' => 'آدرس وب‌سایت معتبر نیست.',
            'logo_file.uploaded' => 'لوگوی مشتری بارگذاری نشد. حجم فایل نباید از محدودیت سرور بیشتر باشد.',
            'logo_file.image' => 'لوگو باید فایل تصویری باشد.',
            'logo_file.mimes' => 'فرمت لوگو باید jpg، jpeg، png یا webp باشد.',
            'logo_file.max' => 'حجم لوگو نباید بیشتر از ۲ مگابایت باشد.',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        unset($data['logo_file'], $data['remove_logo']);

        return $data;
    }

    private function rejectFailedUpload(Request $request): void
    {
        $logo = $request->file('logo_file');

        if ($logo && ! $logo->isValid()) {
            throw ValidationException::withMessages([
                'logo_file' => 'لوگوی مشتری بارگذاری نشد. کد خطای PHP: '.$logo->getError(),
            ]);
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function applyUploadedLogo(Request $request, array &$data, ?Client $client = null): void
    {
        if ($request->boolean('remove_logo') && $client?->logo) {
            $this->deleteStoredPublicAsset($client->logo);
            $data['logo'] = null;
        }

        if ($request->hasFile('logo_file')) {
            if ($client?->logo) {
                $this->deleteStoredPublicAsset($client->logo);
            }

            $data['logo'] = 'storage/'.$request->file('logo_file')->store('clients', 'public');
        }
    }

    private function deleteStoredPublicAsset(string $path): void
    {
        $relativePath = Str::after($path, 'storage/');

        if ($relativePath !== $path) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
