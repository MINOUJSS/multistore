---
name: safe-ui-styling
description: Guidelines and rules for safely modifying HTML/Blade styles and layouts using Bootstrap 5 and CSS3 without breaking existing JavaScript event listeners, selectors, IDs, or structural classes.
---

# Safe UI & Style Editing Skill (Bootstrap 5 + CSS3)

This skill provides mandatory safety guidelines and protocols when editing HTML, Blade templates, and CSS styles. It ensures visual improvements and layout modifications never break existing JavaScript logic, dynamic event listeners, AJAX bindings, or DOM selections.

---

## 1. Tech Stack Requirements
- **Framework**: Bootstrap 5 (with RTL support)
- **Styling**: Vanilla CSS3, CSS custom properties (variables), Flexbox/Grid
- **Scripting Context**: Blade Views, Vanilla JavaScript, jQuery, Livewire

---

## 2. Mandatory Rules for Non-Destructive HTML/Blade Editing

### 🚨 Rule 1: Zero Deletion of `id="..."` Attributes
- **NEVER** delete, rename, or modify an existing `id` attribute on any HTML element.
- IDs are frequently targeted by JavaScript (`document.getElementById()`, `$('#id')`), AJAX submit handlers, chart initializers, or third-party plugins.
- **Correct Approach**: Keep the `id` intact and alter only the visual CSS classes or surrounding containers.

### 🚨 Rule 2: Preserve `data-*` & ARIA Attributes
- Do not remove or alter `data-*` attributes (e.g., `data-id`, `data-action`, `data-bs-toggle`, `data-bs-target`, `data-url`).
- These attributes carry essential state, API endpoints, or Bootstrap 5 modal/dropdown triggers.

### 🚨 Rule 3: Identify & Protect JavaScript Target Classes
- Before removing or replacing CSS classes on an element, classify them into two categories:
  1. **Visual Classes** (safe to update/refactor): `mb-3`, `text-red`, `bg-light`, `p-2`, `col-md-6`.
  2. **Functional / JS Target Classes** (MUST be preserved): Classes starting with `js-`, or used in scripts like `.btn-delete`, `.cart-item-qty`, `.toggle-status`, `.open-modal`.
- **Pre-Edit Audit**: If unsure whether a class is used by JS, search the workspace scripts (`.js` files and Blade inline `<script>` tags) before editing.

---

## 3. Bootstrap 5 & CSS3 Styling Protocols

### A. Bootstrap 5 Utility-First Enhancements
- Use modern Bootstrap 5 utility classes to improve visual aesthetics cleanly:
  - **Spacing & Flex**: `d-flex`, `gap-2`, `gap-3`, `align-items-center`, `justify-content-between`.
  - **Borders & Shadows**: `shadow-sm`, `shadow`, `rounded-3`, `rounded-pill`, `border-0`.
  - **Typography & Colors**: `fw-bold`, `text-secondary`, `fs-6`, `bg-body-tertiary`.
- Avoid adding redundant inline styles (`style="margin-top: 15px;"`) when Bootstrap 5 utilities (`mt-3`) achieve the same effect cleaner.

### B. Custom CSS3 Additions
- Place custom CSS modifications inside designated CSS files or Blade sections (`@section('css')` / `@section('style')`).
- Scope custom CSS rules to avoid leaking styles to parent or sibling components:
  ```css
  /* Good: Scoped selector */
  .admin-dashboard-card .card-title {
      font-weight: 700;
      color: var(--bs-primary);
  }
  ```

---

## 4. Verification & Safe Refactoring Checklist

Before completing any UI or style update, run through this verification checklist:

1. [ ] **ID Check**: Are all original `id` attributes present and unchanged?
2. [ ] **Data Attributes Check**: Are all `data-*` attributes intact?
3. [ ] **JS Targets Check**: Have functional classes used by scripts or event handlers been preserved?
4. [ ] **Form Inputs Check**: Do form elements maintain their `name`, `type`, `value`, and `id` attributes?
5. [ ] **Bootstrap 5 Compliance**: Are grid columns (`col-12`, `col-md-*`) wrapped properly inside a `.row` and `.container`/`.container-fluid`?
5. [ ] **Responsive Table Protocol**: Have all table `<td>` elements received `data-label` attributes and `@media (max-width: 991.98px)` Pure CSS transformations?

---

## 5. Pure CSS Responsive Table Protocol

When building or updating data tables in Blade views, standard HTML tables often break mobile viewports due to multi-column width expansion. Always implement the **Pure CSS Responsive Table Standard**:

### A. HTML Data-Label Requirement
Add a `data-label="..."` attribute to every `<td>` matching its corresponding `<th>` title:
```html
<table class="table" id="myDataTable">
    <thead>
        <tr>
            <th>#</th>
            <th>الاسم</th>
            <th>الحالة</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td data-label="#">1</td>
            <td data-label="الاسم">محمد أحمد</td>
            <td data-label="الحالة"><span class="badge bg-success">نشط</span></td>
        </tr>
    </tbody>
</table>
```

### B. CSS Responsive Transformation Standard
Add the scoped CSS media query (`@media (max-width: 991.98px)`):
```css
@media (max-width: 991.98px) {
    #myDataTable, 
    #myDataTable tbody, 
    #myDataTable tr, 
    #myDataTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #myDataTable thead {
        display: none !important;
    }
    
    #myDataTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #myDataTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #myDataTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #myDataTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
```

