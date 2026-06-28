<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ورود به پنل | دکتر متال</title>
    <style>
        * { box-sizing: border-box; }
        body {
            align-items: center;
            background: #f6f7f9;
            color: #111827;
            display: flex;
            font-family: "Vazirmatn", "IRANSansX", "Yekan Bakh", Tahoma, Arial, sans-serif;
            justify-content: center;
            line-height: 1.8;
            margin: 0;
            min-height: 100vh;
            padding: 20px;
        }
        .login-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            max-width: 420px;
            padding: 28px;
            width: 100%;
        }
        h1 { font-size: 1.6rem; margin: 0 0 6px; }
        p { color: #6b7280; margin: 0 0 22px; }
        label { color: #6b7280; display: block; font-size: .9rem; margin-bottom: 6px; }
        input {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            min-height: 44px;
            padding: 8px 10px;
            width: 100%;
        }
        .field { margin-bottom: 16px; }
        .check-row { align-items: center; display: flex; gap: 8px; margin-bottom: 18px; }
        .check-row input { width: auto; }
        button {
            background: #1f2937;
            border: 0;
            border-radius: 8px;
            color: #fff;
            cursor: pointer;
            min-height: 44px;
            width: 100%;
        }
        .error { color: #dc2626; font-size: .86rem; margin-top: 5px; }
    </style>
</head>
<body>
    <form class="login-card" method="POST" action="{{ route('panel.login.store') }}">
        @csrf
        <h1>ورود به پنل</h1>
        <p>مدیریت محتوای محصولات و دسته‌بندی‌ها</p>

        <div class="field">
            <label for="email">ایمیل</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" autofocus required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="password">رمز عبور</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <label class="check-row">
            <input type="checkbox" name="remember" value="1">
            <span>مرا به خاطر بسپار</span>
        </label>

        <button type="submit">ورود</button>
    </form>
</body>
</html>
