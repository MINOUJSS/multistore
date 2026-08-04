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
6. [ ] **RTL Support**: Are directional utilities compatible with RTL (`ms-*` / `me-*` used appropriately)?
