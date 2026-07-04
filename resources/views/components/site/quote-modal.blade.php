@props([
    'products' => collect(),
    'selectedProduct' => null,
])

@php
    $selectedProductId = old('product_id', $selectedProduct?->id);
@endphp

<div class="quote-modal" data-quote-modal aria-hidden="true">
    <div class="quote-modal-backdrop" data-quote-modal-close></div>
    <section class="quote-modal-panel" role="dialog" aria-modal="true" aria-labelledby="quote-modal-title">
        <button class="quote-modal-close" type="button" data-quote-modal-close aria-label="بستن">×</button>
        <div class="quote-modal-head">
            <span>درخواست ثبت سفارش</span>
            <h2 id="quote-modal-title" data-quote-modal-title>{{ $selectedProduct?->title ?? 'ثبت سریع درخواست سفارش' }}</h2>
            <p>محصول، اطلاعات تماس و مقدار مورد نیاز را ثبت کنید تا واحد فروش شرایط تأمین و قیمت را اعلام کند.</p>
        </div>

        <form class="quote-modal-form" method="post" action="{{ route('quote.store') }}" data-quote-form>
            @csrf
            <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="honeypot">

            <label>
                <span>محصول</span>
                <select name="product_id" required data-quote-product-select>
                    <option value="">انتخاب محصول</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" @selected((string) $selectedProductId === (string) $product->id)>
                            {{ $product->title }}
                        </option>
                    @endforeach
                </select>
                <small class="field-error" data-error-for="product_id"></small>
            </label>

            <label>
                <span>نام رابط</span>
                <input name="contact_person" required autocomplete="name" placeholder="نام و نام خانوادگی">
                <small class="field-error" data-error-for="contact_person"></small>
            </label>

            <label>
                <span>شماره تماس</span>
                <input name="phone" required inputmode="tel" autocomplete="tel" placeholder="مثلا ۰۹۱۲...">
                <small class="field-error" data-error-for="phone"></small>
            </label>

            <label>
                <span>نام شرکت</span>
                <input name="company_name" autocomplete="organization" placeholder="اختیاری">
                <small class="field-error" data-error-for="company_name"></small>
            </label>

            <label>
                <span>ایمیل</span>
                <input type="email" name="email" autocomplete="email" placeholder="اختیاری">
                <small class="field-error" data-error-for="email"></small>
            </label>

            <label>
                <span>مقدار مورد نیاز</span>
                <input name="quantity" placeholder="مثلا ۵ تن یا ۱۰۰۰ کیلوگرم">
                <small class="field-error" data-error-for="quantity"></small>
            </label>

            <label class="is-wide">
                <span>توضیحات</span>
                <textarea name="message" rows="4" placeholder="گرید، زمان تحویل، مقصد یا توضیحات تکمیلی"></textarea>
                <small class="field-error" data-error-for="message"></small>
            </label>

            <div class="quote-modal-actions">
                <button class="btn btn-primary" type="submit">ثبت درخواست</button>
                <button class="btn btn-secondary" type="button" data-quote-modal-close>انصراف</button>
            </div>
        </form>
    </section>
</div>

<div class="site-toast" data-site-toast role="status" aria-live="polite"></div>
