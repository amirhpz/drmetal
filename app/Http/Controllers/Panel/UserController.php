<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\PanelRole;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->with('panelRole')
            ->when($request->filled('q'), function ($query) use ($request): void {
                $search = $request->string('q')->toString();

                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                });
            })
            ->when($request->string('access')->toString() === 'panel', fn ($query) => $query->where('is_panel_user', true))
            ->when($request->string('access')->toString() === 'regular', fn ($query) => $query->where('is_panel_user', false))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('panel.users.index', [
            'users' => $users,
            'panelUserCount' => User::query()->where('is_panel_user', true)->count(),
            'filters' => [
                'q' => $request->string('q')->toString(),
                'access' => $request->string('access')->toString(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('panel.users.create', [
            'user' => new User(['is_panel_user' => true]),
            'roles' => $this->roles(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        User::query()->create($this->validatedData($request));

        return redirect()
            ->route('panel.users.index')
            ->with('success', 'کاربر ایجاد شد.');
    }

    public function edit(User $user): View
    {
        return view('panel.users.edit', [
            'user' => $user,
            'roles' => $this->roles(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validatedData($request, $user);

        if ($this->wouldRemoveCurrentUserAccess($request, $user, $data)) {
            return back()
                ->withInput()
                ->withErrors(['is_panel_user' => 'نمی‌توانید دسترسی پنل حساب فعلی خودتان را حذف کنید.']);
        }

        if ($this->wouldRemoveLastPanelUser($user, $data)) {
            return back()
                ->withInput()
                ->withErrors(['is_panel_user' => 'حداقل یک کاربر باید دسترسی پنل داشته باشد.']);
        }

        $user->update($data);

        return redirect()
            ->route('panel.users.index')
            ->with('success', 'کاربر به‌روزرسانی شد.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->withErrors(['user' => 'نمی‌توانید حساب فعلی خودتان را حذف کنید.']);
        }

        if ($user->is_panel_user && $this->panelUserCountExcluding($user) === 0) {
            return back()->withErrors(['user' => 'حداقل یک کاربر باید دسترسی پنل داشته باشد.']);
        }

        $user->delete();

        return redirect()
            ->route('panel.users.index')
            ->with('success', 'کاربر حذف شد.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?User $user = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'max:255', 'confirmed'],
            'panel_role_id' => ['nullable', 'integer', 'exists:panel_roles,id'],
        ];

        $data = $request->validate($rules, [
            'name.required' => 'نام کاربر را وارد کنید.',
            'email.required' => 'ایمیل کاربر را وارد کنید.',
            'email.email' => 'ایمیل واردشده معتبر نیست.',
            'email.unique' => 'این ایمیل قبلا ثبت شده است.',
            'password.required' => 'رمز عبور را وارد کنید.',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
            'password.confirmed' => 'تکرار رمز عبور با رمز عبور یکسان نیست.',
            'panel_role_id.exists' => 'سطح دسترسی انتخاب‌شده معتبر نیست.',
        ]);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $data['is_panel_user'] = $request->boolean('is_panel_user');
        $data['panel_role_id'] = $data['is_panel_user'] && filled($data['panel_role_id'] ?? null)
            ? $data['panel_role_id']
            : null;

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function wouldRemoveCurrentUserAccess(Request $request, User $user, array $data): bool
    {
        return $request->user()->is($user)
            && $user->is_panel_user
            && ! $data['is_panel_user'];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function wouldRemoveLastPanelUser(User $user, array $data): bool
    {
        return $user->is_panel_user
            && ! $data['is_panel_user']
            && $this->panelUserCountExcluding($user) === 0;
    }

    private function panelUserCountExcluding(User $user): int
    {
        return User::query()
            ->where('is_panel_user', true)
            ->whereKeyNot($user->getKey())
            ->count();
    }

    private function roles()
    {
        return PanelRole::query()->active()->ordered()->get();
    }
}
