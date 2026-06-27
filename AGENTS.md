# Laravel Implementation Brief
## Persian Minimal Corporate Website for an Aluminum Ingot Manufacturer

**Document version:** 1.0
**Prepared for:** Codex implementation inside an existing Laravel project created in PhpStorm
**Primary language of this document:** English
**Target website language:** Persian / Farsi
**Text direction:** Right-to-left (RTL)
**Current phase:** Public website only. No admin panel implementation in this phase.

---

# 1. Executive Summary

Build a professional, minimal, fast, and fully responsive Persian corporate showcase website for an aluminum ingot manufacturer.

The website must present the company, its services, products, industrial credibility, and contact channels. The homepage must also display online metal prices in a clear, modern, and reliable way.

The implementation must be done in Laravel using server-rendered Blade views. The project should be structured so that a separate existing admin panel can be integrated later. For now, **do not implement an admin panel, do not install Filament, Nova, Backpack, Voyager, or any admin dashboard package, and do not create admin routes**.

The codebase must be clean, modular, future-friendly, and easy to extend.

---

# 2. Important Codex Instructions

Codex must follow these instructions carefully:

1. Inspect the existing Laravel project first.
2. Use the Laravel version already installed in the project.
3. Do not upgrade or downgrade Laravel, PHP, Vite, Tailwind, Bootstrap, Gradle, Node, or other project tooling unless absolutely required.
4. Do not implement any admin panel in this phase.
5. Do not add authentication unless the existing project already has it and it is required for another part of the project.
6. Do not convert the project into a SPA.
7. Use Laravel Blade for the frontend.
8. Use Persian RTL UI.
9. Keep all backend code names, class names, table names, routes, and variables in English.
10. Make the data model admin-ready for future integration.
11. Use database seeders to provide editable sample content until the admin panel is integrated.
12. Do not hard-code business data deeply inside Blade views if it should later be editable from the admin panel.
13. Use clean service classes for metal price fetching and caching.
14. If no external metal price API key is configured, the site must still work using seeded fallback prices.
15. All public pages must load without errors even when the metal price API is unavailable.
16. Write clean, readable, maintainable code.
17. Prefer minimal dependencies.
18. Keep frontend design minimal, industrial, and professional.
19. Add useful comments only where they clarify non-obvious logic.
20. Provide final implementation notes after making changes.

---

# 3. Project Goal

The goal is to deliver a complete public-facing website with these pages:

1. Home
2. Services
3. Products
4. Product details
5. About Us
6. Contact Us
7. Quote request submission endpoint

The original business requirement asked for:

- Services introduction
- Products introduction
- About us
- Contact us
- Online metal prices on the homepage
- Minimal UI based on a professional industrial visual identity

This technical brief expands those requirements into an implementation-ready Laravel specification.

---

# 4. Scope of Work

## 4.1 Included in This Phase

This phase includes:

- Public website routes
- Public Blade layout
- Responsive RTL design
- Header and footer
- Homepage
- Services page
- Products page
- Optional product details page
- About page
- Contact page
- Contact form
- Quote request form
- Database tables for services, products, product categories, metal prices, contact messages, quote requests, and site settings
- Seeders with initial content
- Metal price service layer
- Metal price cache
- Optional scheduled command for updating metal prices
- Basic SEO metadata
- Basic Open Graph metadata
- Sitemap route or static sitemap generation
- Robots.txt
- Validation for forms
- Rate limiting for contact and quote forms
- Email notification support for form submissions
- Feature tests for core public pages and forms

## 4.2 Explicitly Excluded From This Phase

Do not implement:

- Admin dashboard
- Admin routes
- Admin controllers
- Admin views
- Filament
- Laravel Nova
- Backpack
- Voyager
- User management dashboard
- Login/register UI
- Role/permission management
- Customer portal
- Online payment
- E-commerce checkout
- Inventory management
- CRM integration
- Multilingual English version
- Blog/news module unless it already exists and is simple to integrate
- Complex API marketplace integration requiring paid keys

---

# 5. Future Admin Panel Integration Requirement

Although no admin panel should be built now, the project must be prepared for one.

This means:

- Use database-driven content where appropriate.
- Add `is_active` fields for public visibility control.
- Add `sort_order` fields for ordering.
- Add `slug` fields for SEO-friendly URLs.
- Add `meta_title` and `meta_description` where useful.
- Add `created_at` and `updated_at` timestamps.
- Keep tables and models clean enough to be controlled by a future admin panel.
- Avoid complex hard-coded arrays in controllers.
- Use seeders for initial content.
- Keep form submissions stored in database.
- Keep file/image fields nullable so future admin upload features can be added.

Do not create admin-specific code yet. The future admin panel should be able to attach to the existing models and tables later.

---

# 6. Recommended Technical Baseline

Codex must inspect the project and adapt to the current installed stack.

Recommended baseline if the project is a normal modern Laravel installation:

- Laravel: existing installed version
- PHP: version required by `composer.json`
- Database: MySQL or MariaDB
- Frontend build: Vite
- Views: Blade
- CSS: Existing setup if available; otherwise custom CSS in `resources/css/app.css`
- JavaScript: Minimal vanilla JavaScript where required
- Icons: Use inline SVG or simple CSS icons; avoid heavy icon dependencies
- Fonts: Use a Persian-capable font if already available; otherwise use a safe font stack and leave a clear CSS variable for future custom font integration

Avoid adding large UI frameworks unless the project already uses one.

---

# 7. Visual Design Direction

The website should look:

- Minimal
- Industrial
- Premium
- Trustworthy
- Technical
- Clean
- Corporate
- Calm
- Modern
- Professional

Avoid:

- Heavy gradients
- Too many colors
- Decorative clutter
- Busy backgrounds
- Low-quality stock image overload
- Too many animations
- Generic startup-style UI
- Overly colorful sections
- Unreadable typography
- Complex navigation

The design should feel appropriate for a B2B industrial company producing aluminum ingots and supplying manufacturers.

---

# 8. Color System

Use a restrained industrial color palette.

## 8.1 CSS Variables

Define these variables in the main CSS file:

```css
:root {
    --color-bg: #f8fafc;
    --color-surface: #ffffff;
    --color-surface-muted: #f1f5f9;
    --color-border: #e2e8f0;

    --color-text: #0f172a;
    --color-text-muted: #64748b;
    --color-text-soft: #94a3b8;

    --color-primary: #1f2a37;
    --color-primary-soft: #334155;
    --color-accent: #2563eb;
    --color-accent-dark: #1d4ed8;
    --color-warning: #f59e0b;

    --color-success: #16a34a;
    --color-danger: #dc2626;

    --radius-sm: 8px;
    --radius-md: 14px;
    --radius-lg: 22px;
    --radius-xl: 30px;

    --shadow-soft: 0 20px 60px rgba(15, 23, 42, 0.06);
    --shadow-card: 0 12px 35px rgba(15, 23, 42, 0.05);

    --container: 1180px;
}
```

## 8.2 Color Usage

- Main background: `--color-bg`
- Cards: `--color-surface`
- Borders: `--color-border`
- Main text: `--color-text`
- Muted text: `--color-text-muted`
- Header: white or very light surface
- Primary CTA: `--color-primary`
- Secondary CTA: transparent with border
- Accent elements: `--color-accent`
- Metal price positive change: `--color-success`
- Metal price negative change: `--color-danger`
- Industrial highlight: `--color-warning`

---

# 9. Typography

The website is Persian and RTL.

Use a Persian-capable font stack. If a local Persian font is not available, use:

```css
font-family:
    "Vazirmatn",
    "IRANSansX",
    "Yekan Bakh",
    "Tahoma",
    "Arial",
    sans-serif;
```

Rules:

- Body text must be readable.
- Avoid overly small text.
- Use strong hierarchy.
- Headings should be clear and compact.
- Use generous line-height for Persian text.
- Use consistent font weights.

Suggested typography:

```css
body {
    font-size: 16px;
    line-height: 1.9;
}

h1 {
    font-size: clamp(2rem, 4vw, 4rem);
    line-height: 1.25;
}

h2 {
    font-size: clamp(1.6rem, 2.4vw, 2.6rem);
    line-height: 1.35;
}

h3 {
    font-size: 1.25rem;
    line-height: 1.5;
}
```

---

# 10. RTL and Localization Requirements

The entire public website must be Persian and right-to-left.

Implementation requirements:

- Set `<html lang="fa" dir="rtl">`.
- Use RTL-aware spacing and layout.
- Prefer logical CSS properties where possible:
  - `margin-inline-start`
  - `margin-inline-end`
  - `padding-inline`
  - `border-inline-start`
- Use Persian UI copy.
- Format dates in a user-friendly Persian-oriented way where possible.
- Use Tehran timezone if the project does not already have another timezone requirement.
- Convert displayed numbers to Persian digits if a helper is implemented.
- Keep internal database values and code identifiers in English.

Optional helper:

Create a small support class for number formatting if useful:

```php
App\Support\PersianNumber::digits($value)
```

This helper can convert English digits to Persian digits for display only.

Do not store Persian digits in numeric database columns.

---

# 11. Site Map

Public routes:

| Page | Method | Route | Name |
|---|---:|---|---|
| Home | GET | `/` | `home` |
| Services | GET | `/services` | `services.index` |
| Products | GET | `/products` | `products.index` |
| Product Details | GET | `/products/{product:slug}` | `products.show` |
| About Us | GET | `/about-us` | `about` |
| Contact Us | GET | `/contact-us` | `contact.index` |
| Submit Contact Form | POST | `/contact-us` | `contact.store` |
| Submit Quote Request | POST | `/quote-request` | `quote.store` |
| Sitemap | GET | `/sitemap.xml` | `sitemap` |
| Robots | GET or static file | `/robots.txt` | optional |

Do not create `/admin` routes in this phase.

---

# 12. Public Page Specifications

## 12.1 Shared Header

The header appears on all pages.

Required elements:

- Company logo or text-based logo fallback
- Navigation links:
  - Home
  - Services
  - Products
  - About Us
  - Contact Us
- Primary CTA:
  - Quote request
  - Contact sales
- Mobile menu button

Behavior:

- Header should be sticky or fixed only if it does not harm usability.
- Active route should be visually highlighted.
- Mobile menu should open/close with minimal JavaScript.
- Navigation labels must be Persian in the UI.
- Route names and code identifiers must remain English.

Suggested Blade component:

```text
resources/views/components/site/header.blade.php
```

## 12.2 Shared Footer

Footer appears on all pages.

Required elements:

- Company short description
- Main links
- Contact phone
- Email
- Address
- Working hours
- Optional social links
- Copyright line

Suggested Blade component:

```text
resources/views/components/site/footer.blade.php
```

## 12.3 Home Page

Route:

```text
GET /
```

Controller:

```text
HomeController@index
```

View:

```text
resources/views/pages/home.blade.php
```

### Home Page Sections

#### A. Hero Section

Purpose: Immediately communicate the company's industrial positioning.

Required content:

- Strong headline about aluminum ingot production
- Short supporting paragraph
- Primary CTA: view products
- Secondary CTA: contact sales
- Minimal industrial visual card or image
- Key trust indicators, such as quality, steady supply, and industrial-grade production

Design:

- Two-column layout on desktop
- One-column layout on mobile
- White/light background
- Minimal visual block for aluminum ingot imagery
- Use subtle borders and shadows

#### B. Online Metal Prices Section

Purpose: Display live or latest cached metal prices.

Metals to display by default:

- Aluminum
- Copper
- Zinc
- Lead
- Nickel
- Gold
- Silver

Each card should show:

- Metal name
- Symbol
- Latest price
- Unit
- Change percentage
- Change direction
- Last updated time
- Source label if available

Behavior:

- If live API is available, show latest fetched data.
- If API is unavailable, show latest cached DB values.
- If no cached DB values exist, show seeded fallback values.
- Never break the homepage because of metal price API failure.
- Clearly show stale data state if data is old.

Suggested UI:

- Desktop: responsive grid
- Mobile: horizontal scroll or stacked cards
- Positive change: subtle green
- Negative change: subtle red
- Neutral: muted gray

#### C. Company Introduction Preview

Purpose: Briefly introduce the company.

Content:

- Short paragraph about the manufacturer
- Mention quality, supply reliability, and industrial customers
- CTA to About page

#### D. Featured Products

Show 3 to 6 active products.

Each product card:

- Title
- Category
- Short description
- Key specification, if available
- Image placeholder or image
- CTA to product details or products page

#### E. Featured Services

Show 3 to 6 active services.

Each service card:

- Icon or simple visual mark
- Title
- Short description

#### F. Why Choose Us

Show concise value propositions:

- Stable quality
- Transparent pricing
- Industrial production capacity
- Reliable delivery
- Technical support
- Long-term B2B cooperation

#### G. Final CTA

A compact CTA section:

- Message encouraging quote request or sales contact
- CTA to contact page
- CTA to quote form

---

## 12.4 Services Page

Route:

```text
GET /services
```

Controller:

```text
ServicePageController@index
```

View:

```text
resources/views/pages/services/index.blade.php
```

### Sections

#### A. Inner Hero

- Page title
- Short description
- Minimal industrial visual

#### B. Services Grid

Display active services ordered by `sort_order`.

Each service:

- Title
- Short description
- Full description excerpt
- Icon or simple label
- Optional image

Default services:

1. Aluminum ingot production
2. Bulk supply for industrial customers
3. Product analysis and quality control
4. Industrial packaging
5. Logistics and delivery coordination
6. Long-term B2B supply cooperation

#### C. Cooperation Process

Display process steps:

1. Initial request
2. Requirement review
3. Price and terms proposal
4. Order confirmation
5. Production or preparation
6. Quality control
7. Delivery

#### D. CTA

Contact sales or submit quote request.

---

## 12.5 Products Page

Route:

```text
GET /products
```

Controller:

```text
ProductPageController@index
```

View:

```text
resources/views/pages/products/index.blade.php
```

### Sections

#### A. Inner Hero

- Page title
- Short description about aluminum products

#### B. Product Categories

Display active categories:

- Aluminum ingots
- Aluminum billets
- Aluminum alloys
- Custom industrial supply

If filters are implemented:

- Use query string filtering, such as `/products?category=aluminum-ingots`
- Keep it simple and server-rendered

#### C. Product Grid

Display active products ordered by `sort_order`.

Each product card:

- Product title
- Category name
- Short description
- Grade or purity if available
- Applications excerpt
- CTA to product details
- CTA to quote request

#### D. CTA

Encourage contact for technical specs or pricing.

---

## 12.6 Product Details Page

Route:

```text
GET /products/{product:slug}
```

Controller:

```text
ProductPageController@show
```

View:

```text
resources/views/pages/products/show.blade.php
```

This page is recommended even if not originally requested because it improves SEO and gives future admin panel content a natural place to appear.

### Sections

#### A. Product Header

- Product title
- Category
- Short description
- CTA to quote request

#### B. Product Image or Visual Placeholder

- Use actual image if available
- Otherwise show an elegant industrial placeholder card

#### C. Technical Specifications

Display specifications from JSON field or related fields.

Suggested specs:

- Grade
- Purity
- Weight
- Dimensions
- Alloy type
- Packaging type
- Minimum order quantity
- Production standard
- Main applications

#### D. Full Description

Show product details.

#### E. Applications

Show applications as list or tags.

#### F. Related Products

Show up to 3 related active products from the same category.

---

## 12.7 About Us Page

Route:

```text
GET /about-us
```

Controller:

```text
AboutPageController@index
```

View:

```text
resources/views/pages/about.blade.php
```

### Sections

#### A. Inner Hero

- Page title
- Short description

#### B. Company Story

Describe company background, production focus, and industrial market.

#### C. Mission and Vision

Mission:

- Produce and supply reliable aluminum products for industrial customers.

Vision:

- Become a trusted regional supplier of aluminum ingots and related products.

#### D. Values

Display values:

- Quality
- Transparency
- Reliability
- Responsibility
- Sustainability
- Long-term cooperation

#### E. Company Stats

Example stats:

- Years of experience
- Annual production capacity
- Industrial clients
- Product categories
- Quality control checkpoints

Stats should come from site settings or seeded content where possible.

#### F. Quality and Standards

Mention quality control, material analysis, production standards, and documentation.

#### G. Image Gallery Placeholder

Prepare a section for future factory images.

If real images are not available:

- Use minimal placeholders
- Do not use random external images without permission

---

## 12.8 Contact Us Page

Route:

```text
GET /contact-us
POST /contact-us
```

Controller:

```text
ContactPageController@index
ContactPageController@store
```

View:

```text
resources/views/pages/contact.blade.php
```

### Sections

#### A. Contact Information

Show:

- Main phone
- Sales phone
- Email
- Address
- Working hours
- Optional WhatsApp link
- Optional Telegram link

These should come from settings or config fallback.

#### B. Contact Form

Fields:

- Full name
- Phone
- Email, optional
- Subject
- Message

Validation:

- Full name required, max 120
- Phone required, max 30
- Email nullable, valid email, max 190
- Subject nullable, max 160
- Message required, min 10, max 5000

Behavior:

- Store in `contact_messages`
- Send notification email if mail config exists
- Show success message
- Redirect back to contact page
- Apply rate limiting
- Use CSRF protection
- Add honeypot field to reduce spam

#### C. Quote Request Form

Can be a separate section on the same page or a CTA section that posts to `/quote-request`.

Fields:

- Company name
- Contact person
- Phone
- Email, optional
- Product, optional select
- Quantity, optional
- Message

Validation:

- Company name nullable, max 160
- Contact person required, max 120
- Phone required, max 30
- Email nullable, email, max 190
- Product nullable, must exist if selected
- Quantity nullable, max 120
- Message nullable, max 5000

#### D. Map Placeholder

Prepare a map section.

Do not require Google Maps API. Use one of these approaches:

- Static map placeholder with address
- OpenStreetMap iframe if allowed by project policy
- Future configurable map embed in settings

---

# 13. Database Schema

Create migrations for the following tables if they do not already exist.

Codex must check existing migrations first to avoid duplicate table creation.

---

## 13.1 `product_categories`

Purpose: Store product categories for future admin management.

| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned | primary |
| title | string | required |
| slug | string | unique |
| description | text nullable | optional |
| image | string nullable | future upload |
| is_active | boolean | default true |
| sort_order | integer | default 0 |
| meta_title | string nullable | SEO |
| meta_description | text nullable | SEO |
| created_at | timestamp | default Laravel |
| updated_at | timestamp | default Laravel |

Indexes:

- unique `slug`
- index `is_active`
- index `sort_order`

---

## 13.2 `products`

Purpose: Store products.

| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned | primary |
| product_category_id | foreignId nullable | constrained to product_categories, null on delete |
| title | string | required |
| slug | string | unique |
| short_description | text nullable | card description |
| description | longText nullable | full details |
| featured_image | string nullable | future upload |
| gallery | json nullable | future images |
| specifications | json nullable | key-value technical specs |
| applications | json nullable | list of applications |
| grade | string nullable | quick spec |
| purity | string nullable | quick spec |
| weight | string nullable | quick spec |
| dimensions | string nullable | quick spec |
| packaging | string nullable | quick spec |
| minimum_order_quantity | string nullable | quick spec |
| is_featured | boolean | default false |
| is_active | boolean | default true |
| sort_order | integer | default 0 |
| meta_title | string nullable | SEO |
| meta_description | text nullable | SEO |
| created_at | timestamp | default Laravel |
| updated_at | timestamp | default Laravel |

Indexes:

- unique `slug`
- index `product_category_id`
- index `is_active`
- index `is_featured`
- index `sort_order`

---

## 13.3 `services`

Purpose: Store company services.

| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned | primary |
| title | string | required |
| slug | string | unique |
| short_description | text nullable | card description |
| description | longText nullable | full description |
| icon | string nullable | icon key or CSS class |
| image | string nullable | future upload |
| is_featured | boolean | default false |
| is_active | boolean | default true |
| sort_order | integer | default 0 |
| meta_title | string nullable | SEO |
| meta_description | text nullable | SEO |
| created_at | timestamp | default Laravel |
| updated_at | timestamp | default Laravel |

Indexes:

- unique `slug`
- index `is_active`
- index `is_featured`
- index `sort_order`

---

## 13.4 `metal_prices`

Purpose: Store latest metal prices.

| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned | primary |
| name | string | metal name |
| symbol | string | short symbol, unique |
| price | decimal(18, 4) nullable | latest price |
| unit | string nullable | e.g. USD/ton, USD/oz |
| currency | string nullable | e.g. USD |
| change_amount | decimal(18, 4) nullable | optional |
| change_percent | decimal(8, 4) nullable | optional |
| direction | enum/string | up, down, neutral |
| source | string nullable | api/manual/seed |
| provider | string nullable | provider name |
| last_updated_at | timestamp nullable | external data timestamp |
| is_stale | boolean | default false |
| is_active | boolean | default true |
| sort_order | integer | default 0 |
| raw_payload | json nullable | optional API response snapshot |
| created_at | timestamp | default Laravel |
| updated_at | timestamp | default Laravel |

Indexes:

- unique `symbol`
- index `is_active`
- index `sort_order`
- index `last_updated_at`

Recommended `direction` values:

- `up`
- `down`
- `neutral`

If the database does not support enum comfortably, use a string with validation in code.

---

## 13.5 `contact_messages`

Purpose: Store contact form submissions.

| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned | primary |
| full_name | string | required |
| phone | string | required |
| email | string nullable | optional |
| subject | string nullable | optional |
| message | text | required |
| status | string | default new |
| ip_address | string nullable | optional |
| user_agent | string nullable | optional |
| admin_note | text nullable | future admin |
| created_at | timestamp | default Laravel |
| updated_at | timestamp | default Laravel |

Recommended `status` values:

- `new`
- `reviewed`
- `replied`
- `closed`

No admin panel now, but status makes the table admin-ready.

---

## 13.6 `quote_requests`

Purpose: Store quote request submissions.

| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned | primary |
| product_id | foreignId nullable | constrained to products, null on delete |
| company_name | string nullable | optional |
| contact_person | string | required |
| phone | string | required |
| email | string nullable | optional |
| quantity | string nullable | flexible quantity text |
| message | text nullable | optional |
| status | string | default new |
| ip_address | string nullable | optional |
| user_agent | string nullable | optional |
| admin_note | text nullable | future admin |
| created_at | timestamp | default Laravel |
| updated_at | timestamp | default Laravel |

Recommended `status` values:

- `new`
- `contacted`
- `quoted`
- `won`
- `lost`
- `closed`

---

## 13.7 `site_settings`

Purpose: Store public website settings and contact information.

| Column | Type | Notes |
|---|---|---|
| id | bigint unsigned | primary |
| key | string | unique |
| value | longText nullable | value |
| group | string nullable | contact, seo, company, social |
| type | string nullable | text, textarea, json, boolean |
| created_at | timestamp | default Laravel |
| updated_at | timestamp | default Laravel |

Example keys:

- `company.name`
- `company.tagline`
- `company.short_description`
- `company.address`
- `contact.main_phone`
- `contact.sales_phone`
- `contact.email`
- `contact.working_hours`
- `social.whatsapp`
- `social.telegram`
- `seo.default_title`
- `seo.default_description`
- `about.mission`
- `about.vision`

No admin UI now, but these settings can be seeded and later managed by the future admin panel.

---

# 14. Eloquent Models

Create or update the following models.

## 14.1 ProductCategory

Path:

```text
app/Models/ProductCategory.php
```

Relationships:

- hasMany Products

Casts:

```php
'is_active' => 'boolean',
'sort_order' => 'integer',
```

Scopes:

- `scopeActive($query)`
- `scopeOrdered($query)`

## 14.2 Product

Path:

```text
app/Models/Product.php
```

Relationships:

- belongsTo ProductCategory

Casts:

```php
'gallery' => 'array',
'specifications' => 'array',
'applications' => 'array',
'is_featured' => 'boolean',
'is_active' => 'boolean',
'sort_order' => 'integer',
```

Scopes:

- `scopeActive($query)`
- `scopeFeatured($query)`
- `scopeOrdered($query)`

Route model binding:

- use slug route binding if possible by overriding `getRouteKeyName()`.

## 14.3 Service

Path:

```text
app/Models/Service.php
```

Casts:

```php
'is_featured' => 'boolean',
'is_active' => 'boolean',
'sort_order' => 'integer',
```

Scopes:

- `scopeActive($query)`
- `scopeFeatured($query)`
- `scopeOrdered($query)`

## 14.4 MetalPrice

Path:

```text
app/Models/MetalPrice.php
```

Casts:

```php
'price' => 'decimal:4',
'change_amount' => 'decimal:4',
'change_percent' => 'decimal:4',
'last_updated_at' => 'datetime',
'is_stale' => 'boolean',
'is_active' => 'boolean',
'raw_payload' => 'array',
'sort_order' => 'integer',
```

Scopes:

- `scopeActive($query)`
- `scopeOrdered($query)`

Useful methods:

- `isUp()`
- `isDown()`
- `isNeutral()`
- `formattedPrice()`
- `formattedChangePercent()`

## 14.5 ContactMessage

Path:

```text
app/Models/ContactMessage.php
```

Casts:

```php
```

No special casts required unless status is implemented as enum.

## 14.6 QuoteRequest

Path:

```text
app/Models/QuoteRequest.php
```

Relationships:

- belongsTo Product nullable

## 14.7 SiteSetting

Path:

```text
app/Models/SiteSetting.php
```

Useful static methods:

- `getValue(string $key, mixed $default = null)`
- `getGroup(string $group): array`

Add caching if useful.

---

# 15. Controllers

Use public-facing controllers under:

```text
app/Http/Controllers
```

or, if project convention prefers namespaces:

```text
app/Http/Controllers/Front
```

Keep naming consistent with existing project.

## 15.1 HomeController

Responsibilities:

- Load featured products
- Load featured services
- Load metal prices through `MetalPriceService`
- Load important site settings
- Return home view

Pseudo logic:

```php
public function index(MetalPriceService $metalPriceService)
{
    $featuredProducts = Product::active()->featured()->ordered()->take(6)->get();
    $featuredServices = Service::active()->featured()->ordered()->take(6)->get();
    $metalPrices = $metalPriceService->getHomepagePrices();

    return view('pages.home', compact(
        'featuredProducts',
        'featuredServices',
        'metalPrices'
    ));
}
```

## 15.2 ServicePageController

Responsibilities:

- Load active services ordered
- Return services index view

## 15.3 ProductPageController

Responsibilities:

- Load product categories
- Load active products
- Filter by category if query param exists
- Show product details by slug
- Load related products

## 15.4 AboutPageController

Responsibilities:

- Load company settings
- Return about view

## 15.5 ContactPageController

Responsibilities:

- Show contact page
- Store contact form submissions
- Send email notification if configured
- Redirect with success message

## 15.6 QuoteRequestController

Responsibilities:

- Store quote request submissions
- Send email notification if configured
- Redirect with success message

## 15.7 SitemapController

Optional but recommended.

Responsibilities:

- Generate simple XML sitemap from static routes and active products
- Return XML response

---

# 16. Form Requests and Validation

Create dedicated request classes.

## 16.1 ContactMessageRequest

Path:

```text
app/Http/Requests/ContactMessageRequest.php
```

Rules:

```php
return [
    'full_name' => ['required', 'string', 'max:120'],
    'phone' => ['required', 'string', 'max:30'],
    'email' => ['nullable', 'email', 'max:190'],
    'subject' => ['nullable', 'string', 'max:160'],
    'message' => ['required', 'string', 'min:10', 'max:5000'],
    'website' => ['nullable', 'size:0'], // honeypot
];
```

The `website` field is a hidden honeypot field. If filled, reject silently or validation fails.

## 16.2 QuoteRequestStoreRequest

Path:

```text
app/Http/Requests/QuoteRequestStoreRequest.php
```

Rules:

```php
return [
    'product_id' => ['nullable', 'integer', 'exists:products,id'],
    'company_name' => ['nullable', 'string', 'max:160'],
    'contact_person' => ['required', 'string', 'max:120'],
    'phone' => ['required', 'string', 'max:30'],
    'email' => ['nullable', 'email', 'max:190'],
    'quantity' => ['nullable', 'string', 'max:120'],
    'message' => ['nullable', 'string', 'max:5000'],
    'website' => ['nullable', 'size:0'], // honeypot
];
```

Customize validation messages in Persian.

---

# 17. Routes

In `routes/web.php`, add public routes.

Example:

```php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicePageController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\AboutPageController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServicePageController::class, 'index'])->name('services.index');

Route::get('/products', [ProductPageController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductPageController::class, 'show'])->name('products.show');

Route::get('/about-us', [AboutPageController::class, 'index'])->name('about');

Route::get('/contact-us', [ContactPageController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactPageController::class, 'store'])
    ->middleware('throttle:contact-form')
    ->name('contact.store');

Route::post('/quote-request', [QuoteRequestController::class, 'store'])
    ->middleware('throttle:quote-form')
    ->name('quote.store');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
```

If throttle keys are not configured, either use default throttle middleware or define named limiters in `RouteServiceProvider` or the appropriate Laravel version-specific location.

Do not create admin routes.

---

# 18. Rate Limiting

Add rate limits for forms.

Recommended:

- Contact form: 5 submissions per minute per IP
- Quote form: 3 submissions per minute per IP

The exact location depends on Laravel version. Use the project's current structure.

Example concept:

```php
RateLimiter::for('contact-form', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});

RateLimiter::for('quote-form', function (Request $request) {
    return Limit::perMinute(3)->by($request->ip());
});
```

---

# 19. Metal Price System

The homepage must display online or latest available metal prices.

Because external metal-price APIs can require API keys, paid plans, and rate limits, implement a resilient system.

## 19.1 Requirements

- The homepage must call a service, not an API directly.
- The service must return display-ready metal prices.
- Prices must be cached.
- Prices must also be stored in the database.
- If API fails, use latest DB data.
- If DB is empty, use seed data.
- The site must never crash due to external price API failure.
- The system must support future provider replacement.

## 19.2 Suggested Files

```text
app/Services/Metals/MetalPriceService.php
app/Services/Metals/Contracts/MetalPriceProvider.php
app/Services/Metals/Providers/ManualMetalPriceProvider.php
app/Services/Metals/Providers/ExternalMetalPriceProvider.php
config/metals.php
app/Console/Commands/UpdateMetalPricesCommand.php
```

If the project should remain simpler, one service class is acceptable, but provider separation is more future-proof.

## 19.3 Config

Create:

```text
config/metals.php
```

Suggested config:

```php
return [
    'provider' => env('METAL_PRICE_PROVIDER', 'database'),

    'cache_ttl_seconds' => env('METAL_PRICE_CACHE_TTL', 1800),

    'stale_after_minutes' => env('METAL_PRICE_STALE_AFTER_MINUTES', 120),

    'api' => [
        'base_url' => env('METAL_PRICE_API_BASE_URL'),
        'key' => env('METAL_PRICE_API_KEY'),
        'timeout' => env('METAL_PRICE_API_TIMEOUT', 10),
    ],

    'symbols' => [
        'ALUMINUM',
        'COPPER',
        'ZINC',
        'LEAD',
        'NICKEL',
        'GOLD',
        'SILVER',
    ],
];
```

## 19.4 Environment Variables

Add to `.env.example`:

```dotenv
METAL_PRICE_PROVIDER=database
METAL_PRICE_CACHE_TTL=1800
METAL_PRICE_STALE_AFTER_MINUTES=120
METAL_PRICE_API_BASE_URL=
METAL_PRICE_API_KEY=
METAL_PRICE_API_TIMEOUT=10

CONTACT_NOTIFICATION_EMAIL=
```

Do not commit actual API keys.

## 19.5 MetalPriceService Responsibilities

Methods:

```php
public function getHomepagePrices(): Collection;
public function refreshPrices(): void;
public function markStalePrices(): void;
```

Behavior:

- `getHomepagePrices()` should return active metal prices ordered by `sort_order`.
- It should use Laravel Cache.
- Cache key example: `homepage_metal_prices`.
- It should not throw exceptions to controllers.
- It should log errors if refresh fails.
- It should mark prices stale based on `last_updated_at`.

## 19.6 Artisan Command

Command name:

```text
metals:update-prices
```

Class:

```text
app/Console/Commands/UpdateMetalPricesCommand.php
```

Behavior:

- Calls `MetalPriceService::refreshPrices()`
- Outputs success/failure status
- Logs API errors
- Does not crash the app

## 19.7 Scheduler

If the project uses Laravel 11+ style scheduling, add schedule in the appropriate file.

Suggested frequency:

- Every 30 minutes or hourly

Example concept:

```php
Schedule::command('metals:update-prices')->hourly();
```

Use the project's Laravel version conventions.

## 19.8 Homepage Display Logic

Display fields:

- Metal name
- Symbol
- Price
- Unit
- Change percent
- Last updated
- Stale badge if old

Example display rules:

- If `direction` is `up`, show positive indicator.
- If `direction` is `down`, show negative indicator.
- If `direction` is `neutral`, show muted indicator.
- If `is_stale` is true, show a small "latest available data" style badge in Persian.

---

# 20. Seeders

Create seeders for initial content.

Recommended seeders:

```text
database/seeders/SiteSettingSeeder.php
database/seeders/ProductCategorySeeder.php
database/seeders/ProductSeeder.php
database/seeders/ServiceSeeder.php
database/seeders/MetalPriceSeeder.php
```

Call them from `DatabaseSeeder`.

Seeders should use `updateOrCreate` to be idempotent.

## 20.1 Product Categories Seed Data

Suggested categories:

1. Aluminum Ingots
2. Aluminum Billets
3. Aluminum Alloys
4. Custom Industrial Supply

Use English slugs:

- `aluminum-ingots`
- `aluminum-billets`
- `aluminum-alloys`
- `custom-industrial-supply`

Titles displayed to users must be Persian.

## 20.2 Products Seed Data

Suggested products:

1. Pure Aluminum Ingot
2. Alloy Aluminum Ingot
3. Aluminum Billet
4. Industrial Aluminum Supply

Fields should include:

- title
- slug
- short_description
- description
- specifications
- applications
- grade
- purity
- packaging
- is_featured
- is_active
- sort_order

Product UI text should be Persian.

## 20.3 Services Seed Data

Suggested services:

1. Aluminum ingot production
2. Bulk industrial supply
3. Quality control and analysis
4. Industrial packaging
5. Logistics coordination
6. Long-term B2B cooperation

Service UI text should be Persian.

## 20.4 Metal Price Seed Data

Create default entries:

| Symbol | Name | Unit | Currency | Sort |
|---|---|---|---|---:|
| ALUMINUM | Aluminum | USD/ton | USD | 1 |
| COPPER | Copper | USD/ton | USD | 2 |
| ZINC | Zinc | USD/ton | USD | 3 |
| LEAD | Lead | USD/ton | USD | 4 |
| NICKEL | Nickel | USD/ton | USD | 5 |
| GOLD | Gold | USD/oz | USD | 6 |
| SILVER | Silver | USD/oz | USD | 7 |

Displayed names must be Persian.

Use reasonable placeholder values and mark source as `seed`.

---

# 21. Views and Blade Structure

Recommended structure:

```text
resources/views/
  layouts/
    app.blade.php

  pages/
    home.blade.php
    about.blade.php
    contact.blade.php

    services/
      index.blade.php

    products/
      index.blade.php
      show.blade.php

  components/
    site/
      header.blade.php
      footer.blade.php
      section-heading.blade.php
      button.blade.php
      product-card.blade.php
      service-card.blade.php
      metal-price-card.blade.php
      empty-state.blade.php
      form-error.blade.php
```

If the project has an existing component convention, adapt to it.

---

# 22. Main Layout

`resources/views/layouts/app.blade.php`

Requirements:

- `<html lang="fa" dir="rtl">`
- Meta charset
- Responsive viewport
- Dynamic title
- Dynamic meta description
- Open Graph tags
- Vite CSS/JS
- Body class for page-specific styling if useful
- Header component
- Main content slot/yield
- Footer component
- Flash message area
- Minimal JS for mobile menu

Suggested layout structure:

```blade
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', '')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-site.header />

    <main>
        @yield('content')
    </main>

    <x-site.footer />
</body>
</html>
```

Adapt syntax if anonymous components are not used.

---

# 23. Styling Implementation

Use `resources/css/app.css`.

Required CSS areas:

1. Reset/base
2. CSS variables
3. RTL layout helpers
4. Container
5. Header
6. Mobile menu
7. Buttons
8. Cards
9. Hero sections
10. Metal price grid
11. Product grid
12. Service grid
13. Forms
14. Footer
15. Responsive breakpoints

## 23.1 Layout Helpers

Suggested classes:

```css
.container {
    width: min(100% - 32px, var(--container));
    margin-inline: auto;
}

.section {
    padding-block: clamp(48px, 7vw, 96px);
}

.section-muted {
    background: var(--color-surface-muted);
}
```

## 23.2 Buttons

Classes:

- `.btn`
- `.btn-primary`
- `.btn-secondary`
- `.btn-link`

## 23.3 Cards

Cards should use:

- White background
- Soft border
- Rounded corners
- Very subtle shadow
- Comfortable padding
- Good spacing

## 23.4 Responsive Rules

Breakpoints:

- Small mobile: 360px
- Mobile: 480px
- Tablet: 768px
- Laptop: 1024px
- Desktop: 1280px

Mobile behavior:

- Single-column sections
- Mobile menu
- Compact hero
- Product cards stacked
- Contact forms stacked
- Metal price cards either stacked or horizontally scrollable

---

# 24. JavaScript

Use minimal JavaScript in:

```text
resources/js/app.js
```

Needed behavior:

- Mobile menu open/close
- Optional smooth scrolling
- Optional form loading state

Do not add a frontend framework.

Example responsibilities:

```js
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('is-open');
            toggle.setAttribute(
                'aria-expanded',
                menu.classList.contains('is-open') ? 'true' : 'false'
            );
        });
    }
});
```

---

# 25. Images and Assets

Actual factory/product images may not be available yet.

Implementation should support:

- Product featured image
- Product gallery
- Service image
- Company/factory gallery in future

For now:

- Use elegant CSS-based placeholders.
- Do not hotlink random images.
- Do not use copyrighted external images.
- Keep placeholders minimal and industrial.
- Store future images under `storage/app/public` with `php artisan storage:link` when admin upload is later integrated.

If using public static placeholders:

```text
public/images/placeholders/
```

Keep them simple.

---

# 26. SEO Requirements

Each page should have:

- Unique title
- Meta description
- Proper H1
- Semantic headings
- Canonical URL if possible
- Open Graph title
- Open Graph description
- Organization structured data on homepage
- Product structured data on product details pages if practical
- Alt text for images
- Sitemap
- Robots

## 26.1 Page Titles

Examples in English for implementation intent:

- Home: Aluminum Ingot Manufacturer
- Services: Industrial Aluminum Supply Services
- Products: Aluminum Ingots and Industrial Products
- About: About the Company
- Contact: Contact Sales and Support

Actual displayed titles and meta content must be Persian.

## 26.2 Sitemap

Generate XML with:

- Home
- Services
- Products
- About
- Contact
- Active product detail pages

Do not overcomplicate.

---

# 27. Accessibility Requirements

Minimum requirements:

- Semantic HTML
- Buttons are real buttons
- Links are real links
- Mobile menu has `aria-expanded`
- Images have alt attributes
- Forms have labels
- Error messages are associated with fields visually
- Color contrast should be sufficient
- Keyboard navigation should work
- Avoid animations that interfere with usability

---

# 28. Security Requirements

Implement:

- CSRF protection on forms
- Server-side validation
- Rate limiting on form submissions
- Honeypot fields
- Escape all user-generated output
- Do not display raw form submission data publicly
- Store IP and user agent optionally for spam investigation
- Avoid mass assignment vulnerabilities by defining `$fillable`
- Do not store secrets in code
- Do not commit API keys
- Do not expose detailed exception messages in production
- Use `config()` and `.env`

---

# 29. Email Notification

When contact or quote form is submitted:

- Store the record in the database first.
- If notification email is configured, send an email to site owner.
- If email sending fails, do not fail the user submission.
- Log email failure.

Suggested classes:

```text
app/Mail/ContactMessageReceived.php
app/Mail/QuoteRequestReceived.php
```

Config key:

```text
CONTACT_NOTIFICATION_EMAIL
```

If not set, skip sending.

---

# 30. Flash Messages

Use session flash messages for form success or error.

Example messages must be Persian.

Views must show:

- Success after contact submission
- Success after quote request
- Validation errors near fields

---

# 31. Settings Helper

A future admin panel will likely manage site settings.

For now, create:

```text
app/Support/SiteSettings.php
```

or static methods on `SiteSetting`.

Recommended API:

```php
SiteSettings::get('contact.email', 'info@example.com');
SiteSettings::get('company.name', config('app.name'));
```

Use cache to avoid repeated DB queries.

Keep it simple.

---

# 32. Suggested File Tree After Implementation

The final implementation may look like this:

```text
app/
  Console/
    Commands/
      UpdateMetalPricesCommand.php

  Http/
    Controllers/
      HomeController.php
      ServicePageController.php
      ProductPageController.php
      AboutPageController.php
      ContactPageController.php
      QuoteRequestController.php
      SitemapController.php

    Requests/
      ContactMessageRequest.php
      QuoteRequestStoreRequest.php

  Mail/
    ContactMessageReceived.php
    QuoteRequestReceived.php

  Models/
    Product.php
    ProductCategory.php
    Service.php
    MetalPrice.php
    ContactMessage.php
    QuoteRequest.php
    SiteSetting.php

  Services/
    Metals/
      MetalPriceService.php
      Contracts/
        MetalPriceProvider.php
      Providers/
        DatabaseMetalPriceProvider.php
        ExternalMetalPriceProvider.php

  Support/
    PersianNumber.php
    SiteSettings.php

config/
  metals.php

database/
  migrations/
  seeders/
    SiteSettingSeeder.php
    ProductCategorySeeder.php
    ProductSeeder.php
    ServiceSeeder.php
    MetalPriceSeeder.php

resources/
  css/
    app.css

  js/
    app.js

  views/
    layouts/
      app.blade.php

    pages/
      home.blade.php
      about.blade.php
      contact.blade.php
      services/
        index.blade.php
      products/
        index.blade.php
        show.blade.php

    components/
      site/
        header.blade.php
        footer.blade.php
        section-heading.blade.php
        product-card.blade.php
        service-card.blade.php
        metal-price-card.blade.php
        form-error.blade.php
```

Adapt to the existing project structure where needed.

---

# 33. Implementation Sequence for Codex

Codex should implement in this order:

## Step 1: Inspect Project

Check:

- Laravel version
- PHP version requirement
- Existing routes
- Existing CSS/JS stack
- Existing layout files
- Existing migrations
- Existing models
- Existing frontend dependencies
- Existing database configuration assumptions

Do not overwrite important existing code blindly.

## Step 2: Add Migrations

Add missing tables:

- product_categories
- products
- services
- metal_prices
- contact_messages
- quote_requests
- site_settings

If similar tables already exist, adapt instead of duplicating.

## Step 3: Add Models

Create models with:

- `$fillable`
- casts
- relationships
- scopes

## Step 4: Add Seeders

Create idempotent seeders.

Seed sample Persian content.

Use English slugs.

## Step 5: Add Services

Create metal price service and config.

Ensure fallback behavior.

## Step 6: Add Controllers and Requests

Implement page controllers and form controllers.

## Step 7: Add Routes

Add public routes only.

No admin routes.

## Step 8: Add Views

Create layout, components, and pages.

Ensure RTL.

## Step 9: Add CSS and JS

Implement minimal industrial UI.

Use responsive CSS.

## Step 10: Add Email Classes

Add notification mailables if mail is configured.

## Step 11: Add Sitemap

Implement simple XML sitemap.

## Step 12: Add Tests

Add feature tests.

## Step 13: Run Commands

Run:

```bash
composer dump-autoload
php artisan migrate
php artisan db:seed
npm install
npm run build
php artisan test
```

Only run `npm install` if required by the existing project setup.

---

# 34. Testing Requirements

Add feature tests if the project has tests configured.

Recommended tests:

## 34.1 PublicPageTest

Assert these routes return 200:

- `/`
- `/services`
- `/products`
- `/about-us`
- `/contact-us`

## 34.2 ProductPageTest

- Products index loads seeded products
- Product details page loads by slug
- Inactive products are not publicly shown

## 34.3 ContactFormTest

- Valid contact form submission stores record
- Invalid submission returns validation errors
- Honeypot rejects spam-like submission

## 34.4 QuoteRequestTest

- Valid quote request stores record
- Product relation works when product is selected
- Invalid request returns validation errors

## 34.5 MetalPriceTest

- Homepage loads with seeded metal prices
- Homepage does not fail when metal service throws internally
- Stale prices are marked or displayed gracefully

---

# 35. Acceptance Criteria

The implementation is complete when:

1. Website is fully Persian and RTL.
2. Header navigation works.
3. Footer appears on all pages.
4. Homepage loads successfully.
5. Homepage shows metal prices.
6. Metal prices have fallback behavior.
7. Services page shows seeded active services.
8. Products page shows seeded active products.
9. Product details page works by slug.
10. About page displays professional company content.
11. Contact page displays contact information.
12. Contact form validates and stores data.
13. Quote request form validates and stores data.
14. Forms use CSRF protection.
15. Forms have rate limiting.
16. Flash messages work.
17. Pages are responsive.
18. Mobile navigation works.
19. SEO title and meta description exist.
20. Sitemap works.
21. No admin panel exists.
22. No admin package is installed.
23. Database structure is ready for future admin panel integration.
24. Project passes tests or at least no existing tests are broken.
25. `php artisan migrate:fresh --seed` works in local development.
26. `npm run build` works if frontend build is configured.
27. No API failure breaks the public site.

---

# 36. Content Strategy

Since the site is Persian, the actual UI text must be written in Persian.

However, code identifiers remain English.

Content tone:

- Professional
- Industrial
- Concise
- Trust-building
- B2B-oriented
- Technical but understandable

Avoid exaggerated marketing claims unless data is provided.

Use placeholders for uncertain company facts.

Do not invent exact years, capacities, certificates, or client numbers unless they are clearly marked as placeholders.

For example:

- If production capacity is unknown, show a generic phrase or seeded configurable setting.
- If company foundation year is unknown, do not invent a year.
- If certifications are unknown, create a placeholder section that can be edited later.

---

# 37. Data Integrity Rules

Use these rules:

- Slugs must be unique.
- Public pages should only show `is_active = true`.
- Lists should be ordered by `sort_order`, then `id`.
- Product details should not show inactive products.
- Contact submissions should be saved even if email fails.
- Quote submissions should be saved even if email fails.
- Metal prices should be displayed from cache where possible.
- If metal price cache is empty, use database.
- If database is empty, seeders should provide baseline data.

---

# 38. Error Handling

Implement graceful behavior:

- Metal API failure: log and continue with cached/DB data.
- Email failure: log and continue after saving submission.
- Missing image: show placeholder.
- Empty product list: show a friendly empty state.
- Empty services list: show a friendly empty state.
- Invalid product slug: 404.
- Inactive product slug: 404.

Do not expose technical errors to users.

---

# 39. Performance Guidelines

Implement:

- Eager loading for product categories.
- Cache metal prices.
- Cache settings if used frequently.
- Avoid unnecessary queries in Blade.
- Use pagination if products become many.
- Use optimized CSS.
- Avoid heavy JS.
- Avoid large images.
- Use lazy loading for images.

Suggested product index pagination:

```php
Product::active()
    ->with('category')
    ->ordered()
    ->paginate(12);
```

---

# 40. Deployment Notes

Prepare the implementation so deployment can use normal Laravel commands:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

Scheduler cron for production if metal price updates are enabled:

```cron
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

Do not assume the production server is ready. Keep deployment steps documented in final notes.

---

# 41. Future Admin Panel Compatibility

When the existing admin panel is integrated later, it should be able to manage:

- Product categories
- Products
- Services
- Metal prices
- Site settings
- Contact messages
- Quote requests
- SEO fields
- Images

To support that future integration now:

- Keep models simple.
- Keep field names conventional.
- Add status fields.
- Add active flags.
- Add sort order fields.
- Add nullable image fields.
- Avoid hard-coded content in views where it should be editable.
- Use DB seeders for initial data.
- Avoid admin-specific assumptions.

Do not implement the admin now.

---

# 42. Do Not Do List

Codex must not:

- Install Filament
- Install Laravel Nova
- Install Backpack
- Install Voyager
- Create `/admin`
- Create dashboard UI
- Add authentication just for this task
- Build a SPA
- Use React/Vue unless already required by the project
- Add unnecessary packages
- Hard-code all content into Blade
- Make live API mandatory for homepage
- Break the site when API key is missing
- Use copyrighted external images
- Invent exact business metrics
- Use LTR layout
- Leave forms without validation
- Leave routes unnamed
- Leave tables without timestamps
- Expose raw exceptions to users

---

# 43. Minimal Persian UI Copy Requirement

The implementation must display Persian text in the UI.

Because this document is written in English, Codex should generate natural Persian copy for:

- Navigation labels
- Hero headline
- Hero description
- Product cards
- Service cards
- About page content
- Contact form labels
- Validation messages
- Success messages
- CTA buttons
- Metal price labels

The copy should be formal, concise, industrial, and suitable for an aluminum ingot manufacturer.

Use English slugs and code identifiers.

---

# 44. Suggested Persian UI Label Meanings

Codex should translate these meanings into Persian UI labels:

| Meaning | Usage |
|---|---|
| Home | Header navigation |
| Services | Header navigation |
| Products | Header navigation |
| About Us | Header navigation |
| Contact Us | Header navigation |
| Request a Quote | CTA |
| Contact Sales | CTA |
| View Products | CTA |
| Online Metal Prices | Homepage section |
| Last Updated | Metal price cards |
| Latest Available Data | Stale data badge |
| Aluminum Ingot Production | Service |
| Bulk Industrial Supply | Service |
| Quality Control and Analysis | Service |
| Industrial Packaging | Service |
| Logistics and Delivery | Service |
| Long-term B2B Cooperation | Service |
| Full Name | Contact form |
| Phone Number | Contact form |
| Email | Contact form |
| Subject | Contact form |
| Message | Contact form |
| Send Message | Contact form |
| Company Name | Quote form |
| Contact Person | Quote form |
| Product | Quote form |
| Quantity | Quote form |
| Submit Request | Quote form |
| Your message was submitted successfully | Flash message |
| Your quote request was submitted successfully | Flash message |

---

# 45. Product and Service Content Guidelines

Use sample seed content, but mark it as editable by future admin.

## 45.1 Product Content

Each seeded product should include:

- Title in Persian
- Slug in English
- Short description in Persian
- Full description in Persian
- Technical specs in JSON
- Applications in JSON
- Featured flag
- Active flag
- Sort order

Do not invent unsupported exact values. Use generic placeholders when needed.

## 45.2 Service Content

Each seeded service should include:

- Title in Persian
- Slug in English
- Short description in Persian
- Full description in Persian
- Icon key
- Featured flag
- Active flag
- Sort order

---

# 46. Example Technical Specification JSON for Products

Store product specifications as JSON.

Example shape:

```json
{
    "grade": "Commercial / Custom",
    "purity": "Based on order",
    "weight": "Configurable",
    "packaging": "Industrial packaging",
    "minimum_order_quantity": "Based on agreement"
}
```

Actual displayed labels should be Persian.

---

# 47. Example Applications JSON

Example:

```json
[
    "Casting industries",
    "Extrusion industries",
    "Automotive parts",
    "Industrial manufacturing",
    "Raw material supply"
]
```

Actual displayed values should be Persian.

---

# 48. User Experience Details

## 48.1 Homepage UX

The homepage should answer these questions quickly:

1. What does the company produce?
2. Can the company supply industrial buyers?
3. What products are available?
4. How can I contact sales?
5. What are the latest metal prices?

## 48.2 Product UX

Products should be scannable.

Users should not need to read long paragraphs before seeing:

- Product type
- Grade or purity
- Application
- Quote action

## 48.3 Contact UX

Contact page should make phone and quote request very obvious.

On mobile:

- Phone number should be tappable.
- Email should be tappable.
- Form fields should be large enough.
- CTA should be visible.

---

# 49. Browser Support

Support modern versions of:

- Chrome
- Edge
- Firefox
- Safari mobile
- Android Chrome

Do not use CSS or JS features that break common mobile browsers without fallback.

---

# 50. Final Deliverables Expected From Codex

After implementation, Codex should provide:

1. Summary of files created.
2. Summary of files modified.
3. Database migrations added.
4. Seeders added.
5. Routes added.
6. How to run locally.
7. Any environment variables added.
8. Any assumptions made.
9. Any remaining manual tasks.
10. Confirmation that no admin panel was implemented.

---

# 51. Final Validation Checklist for Codex

Before finishing, verify:

- `php artisan route:list` includes the public routes.
- No `/admin` routes were created.
- `php artisan migrate` works.
- `php artisan db:seed` works.
- `php artisan test` passes if tests exist.
- Homepage renders with metal prices.
- Contact form stores data.
- Quote request form stores data.
- Product details route works.
- Mobile menu works.
- CSS is RTL-friendly.
- No API key is required to view the site.
- No secrets were committed.
- No large unnecessary package was installed.
- Future admin panel integration remains possible.

---

# 52. Implementation Philosophy

Build the public website as a clean Laravel application layer that can later receive an admin panel without refactoring the public website.

The public website should consume models and settings from the database. The future admin panel will eventually manage the same records.

For now, seeders provide the data.

This creates the right balance:

- Immediate public website delivery
- No premature admin implementation
- Future admin readiness
- Clean architecture
- Stable Laravel codebase

---

# 53. Final Note

The most important constraint is:

**Do not implement the admin panel now.**

Prepare the structure for it, but keep this phase focused on the public Persian RTL website with services, products, about, contact, and online metal prices.
