---
name: dashboard-modernizer
description: Modernize dashboard UI interfaces across Admin, Seller, and Supplier panels with glassmorphic cards, gradient stat avatars, dynamic hero banners, responsive charts, and high-contrast accessibility standards while preserving base brand colors and functional bindings.
---

# Dashboard Modernizer & UI Architect Skill

Use this skill when designing, upgrading, or modernizing dashboard interfaces across Multi-Store AI user panels (Seller, Supplier, Admin). It enforces state-of-the-art visual aesthetics, glassmorphism, gradient accents, fluid responsiveness, high-contrast text accessibility, and strict preservation of existing controller bindings and Chart.js DOM elements.

---

## 1. Core Architectural Layout & Visual Identity

Dashboards in Multi-Store AI are structured inside master layout templates (e.g., `layouts.users.dashboard.app`) using modular Blade components for sidebars, navbars, statistics cards, and chart panels.

### Brand Color Preservation Rules
- **Seller Panel Base Color**: `#a40c72` / `#be0681` (Plum / Rich Magenta).
- **Supplier Panel Base Color**: `#1e293b` / `#0f172a` (Slate / Navy Blue).
- **Admin Panel Base Color**: `#4f46e5` / `#3730a3` (Indigo / Dark Violet).
- **Rule**: Never overwrite or dilute the domain's primary identity color when modernizing sidebars or header components. Accent background colors should supplement the primary palette.

---

## 2. Component Design Tokens & Standard Layouts

### A. Dynamic Hero Welcome Banner
Place a hero banner at the top of the dashboard content area (`index.blade.php`) to deliver an immediate premium impression:

```blade
<div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
    <div class="row align-items-center position-relative z-1">
        <div class="col-lg-8 mb-3 mb-lg-0">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                <i class="fa-solid fa-store text-warning"></i>
                <span>{{ __('لوحة التحكم') }}</span>
                <span class="opacity-50">|</span>
                <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
            </div>
            <h1 class="display-6 fw-bold mb-2 text-white text-start">
                مرحباً بك مجدداً، {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-white-50 mb-0 leading-relaxed">
                إليك نظرة شاملة ومحدثة على أداء متجرك الإلكتروني، مبيعاتك اليومية، وتحليلات الزوار.
            </p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                <a href="{{ route('seller.products') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm">
                    <i class="fa-solid fa-plus me-1"></i> إضافة منتج
                </a>
                <a href="{{ route('seller.profile') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                    <i class="fa-solid fa-gear me-1"></i> الإعدادات
                </a>
            </div>
        </div>
    </div>
</div>
```

### B. Modern Statistics Cards (Daily, Weekly, Monthly)
Stat cards use `border-0`, `shadow-sm`, `rounded-4` (18px), soft HSL icon wrappers (`44px x 44px`), and subtle hover lift animations:

```blade
<div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
    <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="stat-icon-wrapper bg-indigo-subtle text-indigo">
                <i class="fa-solid fa-cart-arrow-down fa-lg"></i>
            </span>
            <span class="badge bg-indigo-subtle text-indigo px-2.5 py-1 rounded-pill fw-semibold small">اليوم</span>
        </div>
        <h6 class="text-muted fw-semibold small mb-1">طلبات اليوم</h6>
        <h3 class="fw-bold mb-0 text-dark">{{ $count }}</h3>
    </div>
</div>
```

#### Palette Utility Tokens:
- **Indigo**: `bg-indigo-subtle` (`rgba(79, 70, 229, 0.08)`), `text-indigo` (`#4f46e5`).
- **Emerald**: `bg-emerald-subtle` (`rgba(16, 185, 129, 0.08)`), `text-emerald` (`#10b981`).
- **Rose**: `bg-rose-subtle` (`rgba(244, 63, 94, 0.08)`), `text-rose` (`#f43f5e`).
- **Amber**: `bg-amber-subtle` (`rgba(245, 158, 11, 0.08)`), `text-amber` (`#f59e0b`).

```css
.dashboard-stat-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.dashboard-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.07) !important;
}
.stat-icon-wrapper {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
```

### C. Glassmorphism & Beta Support Section
Collapsible support banners (`#betaSupport`) must feature soft translucent backdrops, direct contact pills, and glass badges:

```blade
<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
    <div class="card-header bg-warning bg-opacity-15 border-0 py-3 px-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2 text-dark">
            <i class="fas fa-flask text-warning fs-5"></i>
            <strong class="fs-6">منصة Dzora في المرحلة التجريبية</strong>
        </div>
        <button class="btn btn-sm btn-light border-0 shadow-sm rounded-circle p-2" type="button" data-bs-toggle="collapse" data-bs-target="#betaSupport">
            <i class="fas fa-chevron-down"></i>
        </button>
    </div>
    <div class="collapse show" id="betaSupport">
        <div class="card-body p-4">
            <!-- Contact Action Pills -->
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <div class="border border-light-subtle rounded-3 p-3 h-100 text-center bg-light bg-opacity-50">
                        <div class="fs-3 mb-1">📞</div>
                        <h6 class="fw-bold mb-1">الهاتف</h6>
                        <div class="fw-bold text-dark mb-3 dir-ltr">0672816709</div>
                        <a href="tel:672816709" class="btn btn-primary btn-sm w-100 rounded-2 fw-semibold">اتصال مباشر</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

---

## 3. Sidebar Modernization Protocol

When upgrading domain sidebars:

1. **Logo & Profile Box**:
   - Encapsulate store logo inside `.logo-avatar-wrapper` with a 50% border radius, 8px blur backdrop, and verification checkmark badge (`.verified-badge`) for approved accounts.
   - Display tenant ID or username inside a glass pill badge (`.user-tenant-badge`).
2. **Store Action Button ("الإنتقال إلى المتجر")**:
   - Style with `.store-visit-btn`: `background: linear-gradient(135deg, rgba(255,255,255,0.22), rgba(255,255,255,0.1)); backdrop-filter: blur(10px); border-radius: 12px;`.
3. **Menu Links & Active Route Highlights**:
   - Round menu items (`10px`).
   - Use `request()->routeIs('domain.*')` to dynamically apply `.active` states with solid white indicator borders and elevated background.
   - Preserve all dropdown submenus (`.sub-btn`, `.sub-menu`, `.sub-item`).

---

## 4. Color Contrast & Accessibility Protocols

To ensure WCAG AAA compliance across dark and light dashboard backgrounds:

1. **Dark Gradient Hero Banners**:
   - Primary action buttons: `btn-warning text-dark fw-bold` (Yellow background, dark text).
   - Secondary action buttons: `btn-outline-light text-white fw-bold border-2` (Solid white outline & clear white text).
   - **Prohibited**: Do NOT use translucent `btn-light bg-opacity-10 text-white` without solid borders, as it causes text contrast failure.
2. **Light Background Cards**:
   - Use dark text (`#1e293b` or `text-dark`) with muted subtitles (`text-muted small`).

---

## 5. Safe UI Styling & DOM Preservation Rules

1. **Chart Bindings**:
   - Never remove or rename Chart canvas IDs (`#ordersChart`, `#statusChart`, `#visitorsChart`) or time filter select IDs (`#timeRange`, `#visitorsTimeRange`).
   - Ensure canvas containers maintain explicit minimum height (`min-height: 260px; position: relative;`).
2. **Modal & JS Bindings**:
   - Preserve all data attributes (`data-bs-toggle`, `data-bs-target`, `data-id`).
