# Laravel Implementation Brief
## Dr Metal Metallurgical Industries Website and Custom Panel

**Project:** Dr Metal Metallurgical Industries
**Persian name:** صنایع متالورژی دکتر متال
**Brand:** دکتر متال / Dr Metal
**Primary language:** Persian / Farsi
**Text direction:** RTL
**Framework:** Existing Laravel installation
**Current scope:** Public website plus a lightweight custom Laravel panel

---

# 1. Current Project Reality

This project started as a public Persian corporate website, but the scope has evolved. The current application now includes:

- Public Persian RTL website
- Custom Laravel panel under `/panel`
- Panel authentication
- Panel users and access control
- Product category management
- Product management with featured image and gallery upload
- BRS API metal/currency price integration
- Clients and certifications public pages
- Dr Metal company identity and content

Future work must treat the custom panel as an intentional part of the project. Do not follow older “public only / no panel” assumptions.

---

# 2. Company Identity

Use this identity consistently across public pages, SEO metadata, seeders, and editable settings.

- Persian company name: صنایع متالورژی دکتر متال
- English company name: Dr Metal Metallurgical Industries
- Brand name: دکتر متال / Dr Metal
- Legal/company background name: شرکت برتر فناوران راکا
- Persian slogan: پرتوی فناوری و دانش
- English slogan: The Ray of Technology and Science
- Website: www.drmetalco.ir
- Phone: +۹۱۲۶۵۹۱۶۰۱۰
- Address: شهرک صنعتی عباس‌آباد، مولوی جنوبی، خیابان ۱۰/۷، پلاک ۵۷۳

Company introduction:

شرکت برتر فناوران راکا متشکل از تیمی متخصص، خوش‌فکر و پویا است که با نزدیک به یک دهه نام نیک در صنعت فلزات، با برند دکتر متال فعالیت می‌کند. این مجموعه در حوزه طراحی، تولید، بهینه‌سازی و تأمین محصولات و قطعات فلزی، به‌ویژه آلومینیوم و فلزات رنگین، فعالیت دارد.

Keep reusable business content in one of these places:

- Database seeders when it should be editable later from the panel
- `config/company.php` for structured reusable company profile data
- Blade components for repeatable presentation

Avoid scattering important business facts as one-off hard-coded text in unrelated Blade files.

---

# 3. Technical Principles

1. Use the Laravel version already installed.
2. Do not upgrade/downgrade PHP, Laravel, Vite, Tailwind, Composer packages, or Node tooling unless explicitly required.
3. Use server-rendered Blade, not SPA architecture.
4. Keep UI Persian and RTL.
5. Keep code identifiers, routes, class names, table names, and variables in English.
6. Prefer simple Laravel conventions over new abstractions.
7. Prefer minimal dependencies; do not install admin packages such as Filament, Nova, Backpack, or Voyager.
8. The custom panel must remain lightweight and project-native.
9. Keep models and tables admin-ready with `is_active`, `sort_order`, `slug`, SEO fields, and nullable image fields where appropriate.
10. Store form submissions in the database.
11. Never commit secrets, API keys, `.env`, uploaded private files, logs, `vendor`, or `node_modules`.
12. Public pages must not break when the external price API is unavailable.

---

# 4. Public Website Scope

Current and expected public routes:

| Page | Method | Route | Name |
|---|---:|---|---|
| Home | GET | `/` | `home` |
| Services / Fields | GET | `/services` | `services.index` |
| Clients | GET | `/clients` | `clients.index` |
| Certifications | GET | `/certifications` | `certifications.index` |
| Products | GET | `/products` | `products.index` |
| Product Details | GET | `/products/{product:slug}` | `products.show` |
| About | GET | `/about-us` | `about` |
| Contact | GET | `/contact-us` | `contact.index` |
| Contact Submit | POST | `/contact-us` | `contact.store` |
| Quote Submit | POST | `/quote-request` | `quote.store` |
| Sitemap | GET | `/sitemap.xml` | `sitemap` |
| Robots | GET | `/robots.txt` | inline/static |

The homepage should prioritize:

1. Dr Metal hero
2. Online prices for gold, aluminum, dollar, and euro
3. Company introduction
4. Fields of activity
5. Founder highlight
6. Clients
7. Certifications
8. Products
9. Contact CTA

---

# 5. Panel Scope

The custom panel exists under:

```text
/panel
```

Current panel sections:

- Dashboard
- Panel users and access control
- Product categories
- Products

Posts are now in scope and should be implemented as a professional panel section.

Panel implementation rules:

1. Use existing custom panel layout and Blade components.
2. Do not install an admin package.
3. Protect panel routes with existing `auth` and `panel` middleware.
4. Keep panel forms Persian, clear, and safe.
5. Use server-side validation.
6. Use CSRF protection.
7. Avoid deleting the current admin’s own access.
8. Keep destructive actions behind confirmation.
9. Use reusable panel components where possible:
   - `x-panel.card`
   - `x-panel.button`
   - `x-panel.badge`
   - `x-panel.table-wrap`
   - `x-panel.form-actions`
   - `x-panel.section-head`

---

# 6. Posts Section Requirements

Implement a complete post management section in the custom panel.

Recommended public-facing purpose:

- News
- Articles
- Educational metallurgy content
- Company updates
- Technical notes about aluminum, die-casting, non-ferrous metals, certifications, and industrial supply

Suggested table: `posts`

Recommended columns:

| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned | primary |
| title | string | required |
| slug | string | unique, English/URL-safe |
| excerpt | text nullable | summary/card text |
| body | longText nullable | full content |
| featured_image | string nullable | uploaded image |
| category | string nullable | simple category label |
| author_name | string nullable | optional |
| published_at | timestamp nullable | null means draft/unpublished |
| is_featured | boolean | default false |
| is_active | boolean | default true |
| sort_order | integer | default 0 |
| meta_title | string nullable | SEO |
| meta_description | text nullable | SEO |
| created_at | timestamp | Laravel default |
| updated_at | timestamp | Laravel default |

Indexes:

- unique `slug`
- index `is_active`
- index `is_featured`
- index `published_at`
- index `sort_order`

Recommended model: `App\Models\Post`

Model expectations:

- `$fillable` or PHP attributes consistent with the project
- casts for booleans, integer, `published_at`
- scopes:
  - `active`
  - `published`
  - `featured`
  - `ordered`
- route model binding by slug if public post pages are added

Panel routes:

```php
Route::resource('posts', PanelPostController::class)->except('show');
```

Panel pages:

```text
resources/views/panel/posts/index.blade.php
resources/views/panel/posts/create.blade.php
resources/views/panel/posts/edit.blade.php
resources/views/panel/posts/_form.blade.php
```

Panel form should include:

- Title
- Slug
- Excerpt
- Body
- Featured image upload with preview
- Category
- Author name
- Published date/time
- Active/draft controls
- Featured toggle
- Sort order
- SEO title
- SEO description

Upload behavior:

- Store under public disk, preferably `storage/app/public/posts`
- Save DB path as `storage/posts/...`, matching current product image pattern
- Validate image type and max size
- Support removing existing featured image
- Reuse or mirror the polished upload widget style from product forms

Seeder:

- Add a `PostSeeder` with 3-5 professional Persian sample posts
- Keep content concise and realistic
- Avoid unsupported claims or invented certifications

Optional public routes:

If requested, add public blog/news pages later:

| Page | Method | Route | Name |
|---|---:|---|---|
| Posts | GET | `/posts` | `posts.index` |
| Post Details | GET | `/posts/{post:slug}` | `posts.show` |

Do not add public posts pages unless the user asks or it is clearly required by the current task.

---

# 7. Price API Requirements

The homepage price section must show exactly:

- Gold / طلا
- Aluminum / آلومینیوم
- Dollar / دلار
- Euro / یورو

External provider:

```text
https://Api.BrsApi.ir/Market/Commodity.php?key=...
https://Api.BrsApi.ir/Market/Gold_Currency.php?key=...
```

Environment variables:

```env
BRS_API_KEY=
BRS_COMMODITY_API_URL=https://Api.BrsApi.ir/Market/Commodity.php
BRS_GOLD_CURRENCY_API_URL=https://Api.BrsApi.ir/Market/Gold_Currency.php
METAL_PRICE_CACHE_TTL=300
```

Scheduled command:

```bash
php artisan metals:refresh-prices
```

Laravel scheduler:

```php
Schedule::command('metals:refresh-prices')->everyFiveMinutes();
```

Production cron:

```cron
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

If the host has no SSH, document cPanel Cron usage clearly.

Rules:

- API key must only live in `.env`
- API failure must log and fall back to database/cache
- Toman prices should display without decimals
- Dollar-based prices may display decimals

---

# 8. Database Content and Seeders

Use idempotent seeders with `updateOrCreate` where practical.

Current seeders include:

- Site settings
- Product categories
- Products
- Services / fields
- Metal prices
- Panel user

Future post work should add:

- `PostSeeder`

Existing host databases may retain old seeded content. When changing core settings, provide SQL or reseeding instructions for cPanel/phpMyAdmin deployments.

---

# 9. Design Direction

Public website:

- Industrial
- Clean
- Premium
- Trustworthy
- Technical
- RTL
- White, dark gray, steel gray, black, and orange accent palette
- Use actual uploaded imagery where available
- Use CSS industrial placeholders where real images are absent

Panel:

- Fast
- Minimal
- Professional
- Dense enough for repeated admin use
- Modular Blade components
- No decorative clutter
- No nested cards unless truly necessary
- Forms should be organized into clear sections
- Upload widgets should be polished and predictable

Avoid:

- Heavy gradients
- One-page content dumping
- Overcrowded poster-like layout
- External copyrighted images
- Unnecessary frontend frameworks
- Large UI packages

---

# 10. Security and Deployment Rules

Security:

- CSRF on forms
- Server-side validation
- Honeypot for public forms
- Rate limiting on contact and quote forms
- Escape user output
- Do not expose exceptions in production
- Do not commit `.env`, API keys, uploaded secrets, logs, DB files, `vendor`, or `node_modules`

Deployment:

- Project requires PHP 8.3+
- Local PHP 8.2 cannot run Artisan for this project
- Build assets locally when host has no SSH
- Upload `public/build` after `npm run build`
- If host has no Composer, upload compatible `vendor`
- Clear host cache files after route/config/view changes:

```text
bootstrap/cache/config.php
bootstrap/cache/routes-v*.php
bootstrap/cache/routes.php
bootstrap/cache/packages.php
bootstrap/cache/services.php
storage/framework/views/*
```

Storage:

- Product uploads use `storage/app/public/products`
- Future post uploads should use `storage/app/public/posts`
- Public URL pattern should be `/storage/...`
- Fallback route may serve storage files if cPanel symlink access fails

---

# 11. Testing and Verification

Before finishing a coding task, run what is possible:

```bash
npm run build
git diff --check
php -l changed/php/file.php
php artisan test
```

If `php artisan test` fails because the local machine is using PHP 8.2, report that clearly. Do not present it as an application failure.

Useful checks:

- Public pages render
- Panel pages render
- Upload forms preserve field names expected by controllers
- No risky Blade directives inside component tags such as `<x-panel.button @disabled(...)>`
- No secrets in tracked files
- Sitemap includes new public routes when public pages are added

---

# 12. Current Known Notes

- The original public-only brief is superseded by this file.
- The custom panel is now part of the accepted scope.
- Posts panel is the next requested feature.
- `public/build.zip` is a local deployment artifact and should not be committed unless deliberately required.
- Existing production/cPanel deployments may need manual cache clearing and database setting updates.
