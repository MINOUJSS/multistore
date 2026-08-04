---
name: landing-page-designer
description: Design, structure, and build high-converting, responsive, multi-language landing pages for Multi-Store AI following the modular Blade layout pattern, glassmorphic UI system (#B03882), and Bootstrap 5 standards.
---

# Landing Page Designer & Architect Skill

Use this skill when designing, scaffolding, or modernizing landing pages or marketing sections in the Multi-Store AI application.

---

## 1. Core Architectural Layout (Modular Blade Pattern)

Landing pages follow the master layout structure defined in `resources/views/site/layouts/app.blade.php`.
Every main landing page Blade view (e.g., `resources/views/site/index.blade.php`) must cleanly divide sections into modular `@include` components under `resources/views/site/inc/{section}/{section}.blade.php`.

### Standard Main View Template (`index.blade.php`)

```blade
@extends('site.layouts.app')

@section('title')
    {{ config('app.name') }}
@endsection

@section('hero')
    @include('site.inc.header.header')
@endsection

@section('about')
    @include('site.inc.how_its_work.how_its_work')
@endsection

@section('skills')
    @include('site.inc.skills.skills')
@endsection

@section('services')
    @include('site.inc.services.services')
@endsection

@section('faq')
    @include('site.inc.faq.faq')
@endsection

@section('contact')
    @include('site.inc.contact.contact')
@endsection

@section('footer-newsletter')
    @include('site.inc.footer_newsletter.footer_newsletter')
@endsection

@section('footer_js')
    @include('site.inc.footer_newsletter.js.newsletter_js')
@endsection
```

---

## 2. Design Tokens & Visual Identity System

All landing page elements must strictly adhere to the project's brand aesthetic:

- **Primary Identity Color**: `#B03882` (Deep Pink / Magenta Accent).
- **Secondary / Dark Accent**: `#180512`, `#29081e`, `#2D0B20` (Dark Luxury Gradient Backgrounds).
- **Light Background Neutral**: `#faf7f9` or `#fdfbfe`.
- **Gradients**:
  - Buttons / Highlights: `linear-gradient(135deg, #B03882 0%, #d6479f 100%)`
  - Dark Luxury Cards / Footers: `linear-gradient(135deg, #1f0717 0%, #3b102c 45%, #681d4b 85%, #B03882 100%)`
- **Glassmorphism**: `backdrop-filter: blur(14px); background: rgba(45, 11, 32, 0.95); border: 1px solid rgba(176, 56, 130, 0.35);`.

---

## 3. Mandatory Component Standards

1. **Orbiting Interactive Badges**:
   - Floating elements on images must maintain 100% circular icons (`width: 32px; height: 32px; flex-shrink: 0; border-radius: 50%`).
2. **Trust Seals & Badges**:
   - Every service/pricing section must feature trust badges (e.g., `✅ حلول تجارية مسموحة وموثوقة 100%`).
3. **Contact Icon Boxes**:
   - Address, Email, and Phone icons in `contact.blade.php` must have `aspect-ratio: 1 / 1 !important`, `border-radius: 50% !important`, and `flex-shrink: 0 !important` to prevent oval distortion.

---

## 4. Multi-Language (i18n) & RTL/LTR Rules

1. **Translation Keys**:
   - Never hardcode raw text inside Blade views.
   - Always use `{{ __('site.key_name') }}` mapped across `lang/ar/site.php`, `lang/en/site.php`, and `lang/fr/site.php`.
2. **Dynamic Chevron Direction**:
   - In bullet points, links, or navigation buttons, flip directional icons dynamically based on locale:
     ```blade
     <i class="bx bx-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
     ```

---

## 5. Responsive Typography & Mobile Rules

All custom landing page styles must include responsive breakpoints:

```css
@media (max-width: 991px) {
    /* Tablet & Small Screens */
    .section-title h2 { font-size: 22px !important; }
    .hero-h1 { font-size: 26px !important; }
}

@media (max-width: 575px) {
    /* Mobile Screens */
    .section-title h2 { font-size: 19px !important; }
    .hero-h1 { font-size: 22px !important; }
    .btn { width: 100% !important; text-align: center !important; }
}
```
