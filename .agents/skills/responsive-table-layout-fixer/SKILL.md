---
name: responsive-table-layout-fixer
description: Diagnose and resolve horizontal viewport overflow and responsiveness failures caused by data tables, pagination, and CSS Flexbox container minimum width expansion in dashboard layouts.
---

# Responsive Table & Layout Overflow Fixer Skill

This skill provides a systematic protocol for diagnosing and permanently resolving horizontal page overflow, layout stretching, and responsive table breakage in Laravel Blade and Bootstrap dashboard applications.

---

## 1. Problem Symptoms & Diagnosis

### Key Symptoms:
1. **Viewport Horizontal Scroll**: On mobile or tablet devices, the whole dashboard page scrolls horizontally, exposing blank space and breaking the navigation/sidebar layout.
2. **DevTools Deletion Test**: When inspecting the DOM in browser DevTools and deleting the table card container (`<div class="card ...">`), the page **immediately snaps back into a perfect responsive layout**.
3. **Multi-Page Pagination Stretch**: When a query has many pages (e.g. 20+ pages), the `<ul>.pagination` element forces a 600px–800px minimum width line, stretching its parent container.

### Root Cause: The CSS Flexbox `min-width: auto` Trap
In modern dashboards, the main wrapper is typically a Flexbox container:
```html
<div class="app-wraper d-flex">
    <div class="content-side flex-grow-1">...</div>
    <div class="sidebar">...</div>
</div>
```
According to CSS Flexbox specifications, flex items have a default `min-width: auto`. This means a flex child (`.content-side`) **will not shrink below the intrinsic width of its widest child**. 
When a multi-column `<table>` (~1200px) or an unwrapped `.pagination` list (~650px) sits inside `.content-side`, the browser forces `.content-side` to stretch to that full width, causing window-level overflow.

---

## 2. The 3-Step Permanent Resolution Protocol

### Step 1: Layout Flexbox Containment
In the parent dashboard layout file (e.g. `resources/views/layouts/admins/app.blade.php` or `layouts/users/dashboard/app.blade.php`), add containment rules to prevent flex items from expanding beyond the viewport:

```css
/* Layout Flexbox Containment */
.app-wraper {
    overflow-x: hidden !important;
}

.content-side {
    min-width: 0 !important;
    max-width: 100% !important;
}
```
> **Why `min-width: 0 !important;` works**: It overrides the flex item's default `min-width: auto`, allowing `.content-side` to shrink to 100% of the screen width regardless of how wide its children are.

---

### Step 2: Table-Responsive Container Containment
In the view containing the data table, ensure the `.table-responsive` wrapper inside the card does not force overflow:

```css
/* Table-responsive containment */
.card-body .table-responsive {
    width: 100% !important;
    max-width: 100% !important;
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch;
}
```

---

### Step 3: Multi-Page Pagination Wrapping
Pagination elements (`.pagination`) by default render with `display: flex; flex-wrap: nowrap;`. When there are many pages, they force a massive horizontal width. Always enforce wrapping:

```css
/* Pagination wrap for all screen sizes */
.pagination {
    flex-wrap: wrap !important;
    justify-content: center !important;
    margin-bottom: 0 !important;
    gap: 4px;
}

.pagination .page-item .page-link {
    font-size: 0.85rem;
    padding: 0.35rem 0.65rem;
    border-radius: 6px !important;
}
```

---

### Step 4: Pure CSS Responsive Mobile Table (Card Transformation)
For screens under 992px (`@media (max-width: 991.98px)`), transform the table into vertically stacked cards:

1. **HTML Requirement**: Ensure every `<td>` has a `data-label="العنوان"` attribute matching its `<th>`.
2. **CSS Standard**:
```css
/* Pure CSS Responsive Table (< 992px) */
@media (max-width: 991.98px) {
    #targetTable,
    #targetTable tbody,
    #targetTable tr,
    #targetTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }

    #targetTable thead {
        display: none !important;
    }

    #targetTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }

    #targetTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }

    #targetTable tbody td:last-child {
        border-bottom: none !important;
    }

    #targetTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
        text-align: right;
    }

    /* Empty state row on mobile */
    #targetTable tbody td.empty-cell,
    #targetTable tbody td[colspan] {
        display: block !important;
        text-align: center !important;
        border: none !important;
        padding: 2.5rem 1rem !important;
    }

    #targetTable tbody td.empty-cell::before,
    #targetTable tbody td[colspan]::before {
        display: none !important;
    }
}
```

---

## 3. Strict Non-Destructive Editing Rules

1. **Preserve All Element IDs**: Never rename or delete `#targetTable`, `#searchInput`, `#statusFilter`, or any other `id`. JavaScript event handlers and AJAX searches depend on them.
2. **Preserve Form Elements & Actions**: Never alter `<form>` action routes (e.g. `destroy`), `@csrf`, `@method`, or delete buttons.
3. **Preserve Action Buttons**: Tooltips, modal triggers (`data-bs-toggle`), and detail links (`route('...show', ...)`) must remain untouched.
4. **Always Clear Blade View Cache**: After making changes to layout or template files, run:
   ```bash
   php artisan view:clear
   ```
