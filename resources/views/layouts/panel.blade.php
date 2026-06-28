<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'پنل مدیریت') | دکتر متال</title>
    <style>
        :root {
            --panel-bg: #f6f7f9;
            --panel-surface: #fff;
            --panel-border: #e5e7eb;
            --panel-text: #111827;
            --panel-muted: #6b7280;
            --panel-primary: #1f2937;
            --panel-accent: #2563eb;
            --panel-danger: #dc2626;
            --panel-success: #16a34a;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--panel-bg);
            color: var(--panel-text);
            font-family: "Vazirmatn", "IRANSansX", "Yekan Bakh", Tahoma, Arial, sans-serif;
            line-height: 1.8;
        }
        a { color: inherit; text-decoration: none; }
        button, input, textarea, select { font: inherit; }
        .panel-shell {
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
            min-height: 100vh;
        }
        .panel-sidebar {
            background: var(--panel-primary);
            color: #fff;
            padding: 24px 18px;
        }
        .panel-brand {
            display: block;
            margin-bottom: 30px;
            font-size: 1.15rem;
            font-weight: 800;
        }
        .panel-nav {
            display: grid;
            gap: 8px;
        }
        .panel-nav a,
        .panel-nav button {
            width: 100%;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: rgba(255, 255, 255, .82);
            cursor: pointer;
            display: block;
            padding: 10px 12px;
            text-align: right;
        }
        .panel-nav a:hover,
        .panel-nav a.is-active,
        .panel-nav button:hover {
            background: rgba(255, 255, 255, .12);
            color: #fff;
        }
        .panel-main {
            min-width: 0;
            padding: 28px;
        }
        .panel-topbar {
            align-items: center;
            display: flex;
            gap: 16px;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .panel-title {
            margin: 0;
            font-size: 1.7rem;
            line-height: 1.4;
        }
        .panel-subtitle {
            color: var(--panel-muted);
            margin: 4px 0 0;
        }
        .panel-card {
            background: var(--panel-surface);
            border: 1px solid var(--panel-border);
            border-radius: 8px;
            padding: 18px;
        }
        .panel-grid {
            display: grid;
            gap: 16px;
        }
        .panel-grid.cols-5 {
            grid-template-columns: repeat(5, minmax(0, 1fr));
        }
        .panel-grid.cols-6 {
            grid-template-columns: repeat(6, minmax(0, 1fr));
        }
        .panel-actions {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .btn {
            align-items: center;
            border: 1px solid var(--panel-border);
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            justify-content: center;
            min-height: 40px;
            padding: 7px 14px;
        }
        .btn-primary {
            background: var(--panel-primary);
            border-color: var(--panel-primary);
            color: #fff;
        }
        .btn-danger {
            background: transparent;
            border-color: rgba(220, 38, 38, .35);
            color: var(--panel-danger);
        }
        .btn-muted {
            background: #fff;
            color: var(--panel-primary);
        }
        .form-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .form-field {
            display: grid;
            gap: 6px;
        }
        .form-field.is-wide {
            grid-column: 1 / -1;
        }
        .form-field label {
            color: var(--panel-muted);
            font-size: .9rem;
        }
        .form-field input,
        .form-field textarea,
        .form-field select {
            border: 1px solid var(--panel-border);
            border-radius: 8px;
            min-height: 42px;
            padding: 8px 10px;
            width: 100%;
        }
        .form-field textarea {
            min-height: 130px;
            resize: vertical;
        }
        .check-row {
            align-items: center;
            display: flex;
            gap: 8px;
            min-height: 42px;
        }
        .check-row input {
            width: auto;
        }
        .panel-table {
            border-collapse: collapse;
            width: 100%;
        }
        .panel-table th,
        .panel-table td {
            border-bottom: 1px solid var(--panel-border);
            padding: 12px 10px;
            text-align: right;
            vertical-align: middle;
        }
        .panel-table th {
            color: var(--panel-muted);
            font-size: .88rem;
            font-weight: 700;
        }
        .badge {
            border-radius: 999px;
            display: inline-flex;
            font-size: .82rem;
            padding: 2px 9px;
        }
        .badge-success {
            background: rgba(22, 163, 74, .1);
            color: var(--panel-success);
        }
        .badge-muted {
            background: #f3f4f6;
            color: var(--panel-muted);
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 16px;
            padding: 12px 14px;
        }
        .alert-success {
            background: rgba(22, 163, 74, .1);
            color: #166534;
        }
        .alert-danger {
            background: rgba(220, 38, 38, .08);
            color: #991b1b;
        }
        .error-text {
            color: var(--panel-danger);
            font-size: .85rem;
        }
        .panel-help {
            color: var(--panel-muted);
            font-size: .82rem;
        }
        .panel-thumb {
            display: block;
            width: 64px;
            height: 48px;
            object-fit: cover;
            border: 1px solid var(--panel-border);
            border-radius: 6px;
        }
        .image-preview-row {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 10px;
        }
        .image-preview-row img {
            width: 140px;
            height: 96px;
            object-fit: cover;
            border: 1px solid var(--panel-border);
            border-radius: 8px;
        }
        .gallery-preview-grid {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            margin-bottom: 10px;
        }
        .gallery-preview-grid label {
            border: 1px solid var(--panel-border);
            border-radius: 8px;
            display: grid;
            gap: 8px;
            padding: 8px;
        }
        .gallery-preview-grid img {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            border-radius: 6px;
        }
        .pagination {
            margin-top: 16px;
        }
        @media (max-width: 900px) {
            .panel-shell {
                grid-template-columns: 1fr;
            }
            .panel-sidebar {
                position: static;
            }
            .panel-grid.cols-5,
            .panel-grid.cols-6,
            .form-grid {
                grid-template-columns: 1fr;
            }
            .panel-main {
                padding: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="panel-shell">
        <aside class="panel-sidebar">
            <a class="panel-brand" href="{{ route('panel.dashboard') }}">پنل دکتر متال</a>
            <nav class="panel-nav" aria-label="ناوبری پنل">
                <a href="{{ route('panel.dashboard') }}" @class(['is-active' => request()->routeIs('panel.dashboard')])>داشبورد</a>
                <a href="{{ route('panel.users.index') }}" @class(['is-active' => request()->routeIs('panel.users.*')])>کاربران پنل</a>
                <a href="{{ route('panel.product-categories.index') }}" @class(['is-active' => request()->routeIs('panel.product-categories.*')])>دسته‌بندی محصولات</a>
                <a href="{{ route('panel.products.index') }}" @class(['is-active' => request()->routeIs('panel.products.*')])>محصولات</a>
                <a href="{{ route('home') }}" target="_blank">مشاهده سایت</a>
                <form method="POST" action="{{ route('panel.logout') }}">
                    @csrf
                    <button type="submit">خروج</button>
                </form>
            </nav>
        </aside>
        <main class="panel-main">
            <header class="panel-topbar">
                <div>
                    <h1 class="panel-title">@yield('heading', 'پنل مدیریت')</h1>
                    @hasSection('subtitle')
                        <p class="panel-subtitle">@yield('subtitle')</p>
                    @endif
                </div>
                @yield('actions')
            </header>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">لطفا خطاهای فرم را بررسی کنید.</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
