<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'پنل مدیریت') | دکتر متال</title>
    <style>
        :root {
            --panel-bg: #f4f6f8;
            --panel-surface: #ffffff;
            --panel-surface-soft: #f8fafc;
            --panel-border: #e5e7eb;
            --panel-border-strong: #d1d5db;
            --panel-text: #111827;
            --panel-muted: #667085;
            --panel-soft: #98a2b3;
            --panel-primary: #18212f;
            --panel-primary-soft: #253246;
            --panel-accent: #2563eb;
            --panel-danger: #dc2626;
            --panel-success: #16a34a;
            --panel-warning: #d97706;
            --panel-radius: 8px;
            --panel-shadow: 0 18px 45px rgba(15, 23, 42, .06);
        }

        * { box-sizing: border-box; }
        html { min-width: 320px; }
        body {
            margin: 0;
            background: var(--panel-bg);
            color: var(--panel-text);
            font-family: "Vazirmatn", "IRANSansX", "Yekan Bakh", Tahoma, Arial, sans-serif;
            font-size: 15px;
            line-height: 1.8;
        }
        a { color: inherit; text-decoration: none; }
        button, input, textarea, select { font: inherit; }
        button:disabled { cursor: not-allowed; opacity: .48; }

        .panel-shell {
            display: grid;
            grid-template-columns: 264px minmax(0, 1fr);
            min-height: 100vh;
        }
        .panel-sidebar {
            background: var(--panel-primary);
            color: #fff;
            display: flex;
            flex-direction: column;
            gap: 22px;
            padding: 22px 16px;
            position: sticky;
            top: 0;
            height: 100vh;
        }
        .panel-brand {
            align-items: center;
            display: flex;
            gap: 10px;
            padding: 4px 6px 12px;
        }
        .panel-brand-mark {
            align-items: center;
            background: #fff;
            border-radius: 8px;
            color: var(--panel-primary);
            display: inline-flex;
            flex: 0 0 38px;
            font-weight: 900;
            height: 38px;
            justify-content: center;
            width: 38px;
        }
        .panel-brand strong {
            display: block;
            font-size: 1.05rem;
            line-height: 1.3;
        }
        .panel-brand span:last-child {
            color: rgba(255, 255, 255, .68);
            display: block;
            font-size: .78rem;
            margin-top: 2px;
        }
        .panel-nav {
            display: grid;
            gap: 6px;
        }
        .panel-nav a,
        .panel-nav button {
            align-items: center;
            background: transparent;
            border: 0;
            border-radius: var(--panel-radius);
            color: rgba(255, 255, 255, .76);
            cursor: pointer;
            display: flex;
            gap: 10px;
            min-height: 42px;
            padding: 9px 10px;
            text-align: right;
            width: 100%;
        }
        .panel-nav a:hover,
        .panel-nav a.is-active,
        .panel-nav button:hover {
            background: rgba(255, 255, 255, .1);
            color: #fff;
        }
        .panel-nav-icon {
            align-items: center;
            background: rgba(255, 255, 255, .1);
            border-radius: 8px;
            display: inline-flex;
            flex: 0 0 28px;
            font-size: .78rem;
            height: 28px;
            justify-content: center;
            width: 28px;
        }
        .panel-sidebar-footer {
            border-top: 1px solid rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .62);
            font-size: .8rem;
            margin-top: auto;
            padding: 14px 8px 0;
        }
        .panel-main {
            min-width: 0;
            padding: 26px;
        }
        .panel-topbar {
            align-items: center;
            display: flex;
            gap: 16px;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .panel-title {
            font-size: 1.55rem;
            line-height: 1.35;
            margin: 0;
        }
        .panel-subtitle {
            color: var(--panel-muted);
            margin: 4px 0 0;
        }
        .panel-card {
            background: var(--panel-surface);
            border: 1px solid var(--panel-border);
            border-radius: var(--panel-radius);
            box-shadow: var(--panel-shadow);
            padding: 18px;
        }
        .panel-stack {
            display: grid;
            gap: 16px;
        }
        .panel-grid {
            display: grid;
            gap: 14px;
        }
        .panel-grid.cols-5 { grid-template-columns: repeat(5, minmax(0, 1fr)); }
        .panel-grid.cols-6 { grid-template-columns: repeat(6, minmax(0, 1fr)); }
        .stat-card {
            min-height: 104px;
            padding: 16px;
        }
        .stat-card strong {
            display: block;
            font-size: 1.75rem;
            line-height: 1.2;
        }
        .stat-label {
            color: var(--panel-muted);
            margin-top: 8px;
        }
        .panel-section-head {
            align-items: center;
            display: flex;
            gap: 12px;
            justify-content: space-between;
            margin-bottom: 14px;
        }
        .panel-section-head h2 {
            font-size: 1.08rem;
            line-height: 1.4;
            margin: 0;
        }
        .panel-actions {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .btn {
            align-items: center;
            border: 1px solid var(--panel-border-strong);
            border-radius: var(--panel-radius);
            cursor: pointer;
            display: inline-flex;
            font-weight: 700;
            gap: 8px;
            justify-content: center;
            min-height: 38px;
            padding: 7px 13px;
            transition: background .15s ease, border-color .15s ease, color .15s ease;
            white-space: nowrap;
        }
        .btn-primary {
            background: var(--panel-primary);
            border-color: var(--panel-primary);
            color: #fff;
        }
        .btn-primary:hover { background: var(--panel-primary-soft); }
        .btn-danger {
            background: #fff;
            border-color: rgba(220, 38, 38, .26);
            color: var(--panel-danger);
        }
        .btn-danger:hover { background: rgba(220, 38, 38, .06); }
        .btn-muted {
            background: #fff;
            color: var(--panel-primary);
        }
        .btn-muted:hover { background: var(--panel-surface-soft); }
        .form-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .form-field {
            display: grid;
            gap: 6px;
        }
        .form-field.is-wide { grid-column: 1 / -1; }
        .form-field label {
            color: var(--panel-muted);
            font-size: .9rem;
            font-weight: 700;
        }
        .form-field input,
        .form-field textarea,
        .form-field select {
            background: #fff;
            border: 1px solid var(--panel-border);
            border-radius: var(--panel-radius);
            color: var(--panel-text);
            min-height: 42px;
            outline: 0;
            padding: 8px 10px;
            width: 100%;
        }
        .form-field input:focus,
        .form-field textarea:focus,
        .form-field select:focus {
            border-color: rgba(37, 99, 235, .55);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
        }
        .form-field textarea {
            min-height: 126px;
            resize: vertical;
        }
        .check-row {
            align-items: center;
            display: flex;
            gap: 8px;
            min-height: 42px;
        }
        .check-row input { width: auto; }
        .table-wrap {
            overflow-x: auto;
            width: 100%;
        }
        .panel-table {
            border-collapse: collapse;
            min-width: 760px;
            width: 100%;
        }
        .panel-table th,
        .panel-table td {
            border-bottom: 1px solid var(--panel-border);
            padding: 13px 10px;
            text-align: right;
            vertical-align: middle;
        }
        .panel-table th {
            color: var(--panel-muted);
            font-size: .82rem;
            font-weight: 800;
            white-space: nowrap;
        }
        .panel-table tbody tr:hover {
            background: var(--panel-surface-soft);
        }
        .badge {
            align-items: center;
            border-radius: 999px;
            display: inline-flex;
            font-size: .8rem;
            font-weight: 800;
            min-height: 25px;
            padding: 2px 9px;
        }
        .badge-success {
            background: rgba(22, 163, 74, .1);
            color: var(--panel-success);
        }
        .badge-danger {
            background: rgba(220, 38, 38, .08);
            color: var(--panel-danger);
        }
        .badge-warning {
            background: rgba(217, 119, 6, .1);
            color: var(--panel-warning);
        }
        .badge-muted {
            background: #eef2f7;
            color: var(--panel-muted);
        }
        .alert {
            border-radius: var(--panel-radius);
            margin-bottom: 14px;
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
            font-size: .84rem;
        }
        .panel-help {
            color: var(--panel-muted);
            font-size: .82rem;
        }
        .panel-thumb {
            background: var(--panel-surface-soft);
            border: 1px solid var(--panel-border);
            border-radius: var(--panel-radius);
            display: block;
            height: 52px;
            object-fit: cover;
            width: 70px;
        }
        .image-preview-row {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 10px;
        }
        .image-preview-row img {
            border: 1px solid var(--panel-border);
            border-radius: var(--panel-radius);
            height: 100px;
            object-fit: cover;
            width: 150px;
        }
        .gallery-preview-grid {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(auto-fill, minmax(128px, 1fr));
            margin-bottom: 10px;
        }
        .gallery-preview-grid label {
            background: var(--panel-surface-soft);
            border: 1px solid var(--panel-border);
            border-radius: var(--panel-radius);
            display: grid;
            gap: 8px;
            padding: 8px;
        }
        .gallery-preview-grid img {
            aspect-ratio: 4 / 3;
            border-radius: 6px;
            object-fit: cover;
            width: 100%;
        }
        .product-form {
            display: grid;
            gap: 18px;
        }
        .product-editor-form {
            display: block;
        }
        .product-form-section {
            background: #fff;
            border: 1px solid var(--panel-border);
            border-radius: var(--panel-radius);
            padding: 18px;
        }
        .product-form-section + .product-form-section {
            margin-top: 0;
        }
        .product-form-section-head {
            align-items: flex-start;
            border-bottom: 1px solid var(--panel-border);
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            padding-bottom: 14px;
        }
        .product-form-section-head h2 {
            font-size: 1.08rem;
            line-height: 1.4;
            margin: 0;
        }
        .product-form-section-head p {
            color: var(--panel-muted);
            margin: 3px 0 0;
        }
        .product-form-step {
            align-items: center;
            background: var(--panel-primary);
            border-radius: var(--panel-radius);
            color: #fff;
            display: inline-flex;
            flex: 0 0 34px;
            font-weight: 900;
            height: 34px;
            justify-content: center;
            width: 34px;
        }
        .upload-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1.25fr);
        }
        .upload-card {
            background: var(--panel-surface-soft);
            border: 1px solid var(--panel-border);
            border-radius: var(--panel-radius);
            display: grid;
            gap: 14px;
            padding: 14px;
        }
        .upload-card-head {
            align-items: flex-start;
            display: flex;
            gap: 12px;
            justify-content: space-between;
        }
        .upload-card-head h3 {
            font-size: 1rem;
            line-height: 1.4;
            margin: 0;
        }
        .upload-card-head p {
            color: var(--panel-muted);
            margin: 3px 0 0;
        }
        .upload-dropzone {
            align-items: center;
            background: #fff;
            border: 1px dashed var(--panel-border-strong);
            border-radius: var(--panel-radius);
            cursor: pointer;
            display: grid;
            gap: 5px;
            justify-items: center;
            min-height: 168px;
            padding: 18px;
            text-align: center;
            transition: border-color .15s ease, background .15s ease;
        }
        .upload-dropzone:hover {
            background: #f9fbff;
            border-color: rgba(37, 99, 235, .5);
        }
        .upload-dropzone input {
            height: 1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            width: 1px;
        }
        .upload-icon {
            align-items: center;
            background: var(--panel-primary);
            border-radius: 999px;
            color: #fff;
            display: inline-flex;
            font-size: 1.35rem;
            font-weight: 800;
            height: 42px;
            justify-content: center;
            line-height: 1;
            width: 42px;
        }
        .upload-dropzone small,
        .upload-preview-item span {
            color: var(--panel-muted);
            font-size: .82rem;
        }
        .current-image-card {
            align-items: center;
            background: #fff;
            border: 1px solid var(--panel-border);
            border-radius: var(--panel-radius);
            display: flex;
            gap: 12px;
            padding: 10px;
        }
        .current-image-card img {
            border-radius: 6px;
            height: 88px;
            object-fit: cover;
            width: 118px;
        }
        .current-gallery-grid,
        .upload-preview-grid {
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
        .upload-preview-grid.single {
            grid-template-columns: minmax(0, 180px);
        }
        .current-gallery-item,
        .upload-preview-item {
            background: #fff;
            border: 1px solid var(--panel-border);
            border-radius: var(--panel-radius);
            display: grid;
            gap: 8px;
            padding: 8px;
        }
        .current-gallery-item img,
        .upload-preview-item img {
            aspect-ratio: 4 / 3;
            border-radius: 6px;
            object-fit: cover;
            width: 100%;
        }
        .upload-preview-item span {
            direction: ltr;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .specs-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        .publish-options {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .toggle-card {
            align-items: flex-start;
            background: var(--panel-surface-soft);
            border: 1px solid var(--panel-border);
            border-radius: var(--panel-radius);
            cursor: pointer;
            display: flex;
            gap: 10px;
            padding: 14px;
        }
        .toggle-card input {
            margin-top: 6px;
        }
        .toggle-card strong,
        .toggle-card small {
            display: block;
        }
        .toggle-card small {
            color: var(--panel-muted);
            margin-top: 2px;
        }
        .pagination { margin-top: 16px; }

        @media (max-width: 1100px) {
            .panel-grid.cols-6 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
        @media (max-width: 900px) {
            .panel-shell { grid-template-columns: 1fr; }
            .panel-sidebar {
                height: auto;
                position: static;
            }
            .panel-nav {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .panel-sidebar-footer { display: none; }
            .panel-main { padding: 18px; }
            .panel-topbar {
                align-items: flex-start;
                flex-direction: column;
            }
            .panel-grid.cols-5,
            .panel-grid.cols-6,
            .form-grid,
            .upload-grid,
            .specs-grid,
            .publish-options {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 560px) {
            .panel-nav { grid-template-columns: 1fr; }
            .panel-main { padding: 14px; }
            .panel-card { padding: 14px; }
            .product-form-section { padding: 14px; }
            .current-image-card {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="panel-shell">
        <aside class="panel-sidebar">
            <a class="panel-brand" href="{{ route('panel.dashboard') }}">
                <span class="panel-brand-mark">DM</span>
                <span>
                    <strong>پنل دکتر متال</strong>
                    <span>مدیریت محتوای سایت</span>
                </span>
            </a>

            <nav class="panel-nav" aria-label="ناوبری پنل">
                <a href="{{ route('panel.dashboard') }}" @class(['is-active' => request()->routeIs('panel.dashboard')])>
                    <span class="panel-nav-icon">دا</span>
                    <span>داشبورد</span>
                </a>
                <a href="{{ route('panel.users.index') }}" @class(['is-active' => request()->routeIs('panel.users.*')])>
                    <span class="panel-nav-icon">کا</span>
                    <span>کاربران پنل</span>
                </a>
                <a href="{{ route('panel.product-categories.index') }}" @class(['is-active' => request()->routeIs('panel.product-categories.*')])>
                    <span class="panel-nav-icon">دس</span>
                    <span>دسته‌بندی محصولات</span>
                </a>
                <a href="{{ route('panel.products.index') }}" @class(['is-active' => request()->routeIs('panel.products.*')])>
                    <span class="panel-nav-icon">مح</span>
                    <span>محصولات</span>
                </a>
                <a href="{{ route('home') }}" target="_blank">
                    <span class="panel-nav-icon">سا</span>
                    <span>مشاهده سایت</span>
                </a>
                <form method="POST" action="{{ route('panel.logout') }}">
                    @csrf
                    <button type="submit">
                        <span class="panel-nav-icon">خر</span>
                        <span>خروج</span>
                    </button>
                </form>
            </nav>

            <div class="panel-sidebar-footer">
                {{ auth()->user()?->name }}
            </div>
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
    @stack('scripts')
</body>
</html>
