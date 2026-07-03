<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\PanelRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PanelRoleController extends Controller
{
    public function index(): View
    {
        return view('panel.roles.index', [
            'roles' => PanelRole::query()
                ->withCount('users')
                ->ordered()
                ->paginate(15),
            'permissions' => $this->permissions(),
        ]);
    }

    public function create(): View
    {
        return view('panel.roles.create', [
            'role' => new PanelRole(['is_active' => true, 'sort_order' => 0, 'permissions' => []]),
            'permissions' => $this->permissions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        PanelRole::query()->create($this->validatedData($request));

        return redirect()
            ->route('panel.roles.index')
            ->with('success', 'سطح دسترسی ایجاد شد.');
    }

    public function edit(PanelRole $role): View
    {
        return view('panel.roles.edit', [
            'role' => $role,
            'permissions' => $this->permissions(),
        ]);
    }

    public function update(Request $request, PanelRole $role): RedirectResponse
    {
        $role->update($this->validatedData($request, $role));

        return redirect()
            ->route('panel.roles.index')
            ->with('success', 'سطح دسترسی به‌روزرسانی شد.');
    }

    public function destroy(PanelRole $role): RedirectResponse
    {
        if ($role->users()->exists()) {
            return back()->withErrors(['role' => 'این سطح دسترسی به کاربر متصل است و قابل حذف نیست.']);
        }

        $role->delete();

        return redirect()
            ->route('panel.roles.index')
            ->with('success', 'سطح دسترسی حذف شد.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?PanelRole $role = null): array
    {
        $permissionKeys = array_keys($this->permissions());

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9-]+$/',
                Rule::unique('panel_roles', 'slug')->ignore($role),
            ],
            'description' => ['nullable', 'string'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in($permissionKeys)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'عنوان سطح دسترسی را وارد کنید.',
            'slug.regex' => 'نامک فقط می‌تواند شامل حروف انگلیسی، عدد و خط تیره باشد.',
            'slug.unique' => 'این نامک قبلا ثبت شده است.',
            'permissions.*.in' => 'یکی از دسترسی‌های انتخاب‌شده معتبر نیست.',
        ]);

        $data['slug'] = $data['slug'] ?: $this->uniqueSlug($data['name'], $role);
        $data['permissions'] = array_values(array_intersect($request->input('permissions', []), $permissionKeys));
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }

    private function uniqueSlug(string $name, ?PanelRole $role = null): string
    {
        $base = Str::slug($name) ?: 'panel-role';
        $slug = $base;
        $counter = 1;

        while (PanelRole::query()
            ->where('slug', $slug)
            ->when($role, fn ($query) => $query->whereKeyNot($role->getKey()))
            ->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * @return array<string, array{label: string, description: string}>
     */
    private function permissions(): array
    {
        return config('panel.permissions', []);
    }
}
