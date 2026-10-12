---
name: Asro Inventory Design System
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#40484d'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#70787e'
  outline-variant: '#c0c7ce'
  surface-tint: '#126588'
  primary: '#0c6385'
  on-primary: '#ffffff'
  primary-container: '#347c9f'
  on-primary-container: '#fcfcff'
  inverse-primary: '#8ccff6'
  secondary: '#455f87'
  on-secondary: '#ffffff'
  secondary-container: '#b5d0fd'
  on-secondary-container: '#3e5980'
  tertiary: '#006483'
  on-tertiary: '#ffffff'
  tertiary-container: '#0f7ea3'
  on-tertiary-container: '#fbfdff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#c4e7ff'
  primary-fixed-dim: '#8ccff6'
  on-primary-fixed: '#001e2c'
  on-primary-fixed-variant: '#004c69'
  secondary-fixed: '#d5e3ff'
  secondary-fixed-dim: '#adc8f5'
  on-secondary-fixed: '#001c3b'
  on-secondary-fixed-variant: '#2d486d'
  tertiary-fixed: '#c0e8ff'
  tertiary-fixed-dim: '#7bd1fa'
  on-tertiary-fixed: '#001e2b'
  on-tertiary-fixed-variant: '#004d66'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  display-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
  display-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
  headline-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  headline-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  title-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  body-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 16px
  label-md:
    fontFamily: Inter
    fontSize: 13px
    fontWeight: '500'
    lineHeight: 18px
  label-sm:
    fontFamily: Inter
    fontSize: 11px
    fontWeight: '600'
    lineHeight: 14px
  data-metric:
    fontFamily: Plus Jakarta Sans
    fontSize: 28px
    fontWeight: '700'
    lineHeight: 34px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-sm: 1rem
  margin: 2rem
  margin-sm: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2.5rem
---

## Brand & Style

This design system embodies a modern, precise enterprise SaaS aesthetic tailored for global inventory management, freight tracking, and intelligent supply chain operations. The emotional goal is calm control over complex logistics: transforming dense logistics manifests, warehouse telemetry, and demand forecasts into an uncluttered, reassuring workspace.

The style fuses **Corporate Modern** with **Soft Scandinavian Minimalism**. It avoids harsh terminal-like enterprise density in favor of luminous, breathable layouts, delicate cool-toned borders, and softly graded pastel backdrops. Visual noise is actively suppressed through light surfaces, gentle atmospheric tinting, and precise typographic cadence, projecting operational reliability, institutional trust, and modern analytical clarity.

## Colors

The palette establishes an airy, cool-tinted enterprise environment centered on calm stability and high legibility across dense data interfaces.

- **Primary (`#3B82A6` - Steel Blue):** The primary brand anchor used for primary action buttons, key interactive active states, selected table rows, and key progress indicators.
- **Secondary (`#1E3A5F` - Deep Slate Navy):** The structural anchor used for primary headings, high-priority telemetry metrics, deep navigation sidebars, and critical state indicators.
- **Tertiary (`#7DD3FC` - Soft Sky / Powder Accent):** Applied conservatively to subtle background highlights, informational accents, active badge backgrounds, and interactive hover tints.
- **Neutral (`#64748B` - Slate Gray):** Handles secondary body copy, muted meta information, and structural dividers.
- **Canvas & Surface Palette:**
  - Base canvas: Pure Crisp White (`#FFFFFF`) layered over an ambient backdrop of Pale Glacial Mist (`#F8FAFC`).
  - Subtle Cool Borders: Defined by `#E2E8F0` and `#EDF2F7`, providing crisp containment without heavy contrast.
  - Gradients: Reserved exclusively for hero dashboard metric cards and summary panels, using ultra-soft linear blends (e.g., `linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%)`).

## Typography

The typographic hierarchy balances modern brand polish with high-density data utility.

- **Plus Jakarta Sans** provides a contemporary, open, and friendly architectural structure for high-level surfaces, titles, and summary KPIs. Its clear geometric apertures keep executive dashboards clean and legible.
- **Inter** is designated for functional labels, status badges, compact table headers, and data grids where tracking and mechanical clarity are essential during multi-line scanning.
- **Numerical Treatment:** All metric values, timestamps, and stock keeping units (SKUs) must use tabular lining figures (`font-variant-numeric: tabular-nums`) to preserve vertical alignment across supply chain ledgers and tables.

## Layout & Spacing

The layout uses a 12-column fluid grid system pinned inside a 1440px max-width container for desktop operations, paired with a permanent collapsible operational sidebar (260px expanded, 72px iconified).

- **Desktop (>= 1200px):** 12 columns, `1.5rem` (`24px`) gutters, and `2rem` (`32px`) canvas margins. Suitable for side-by-side inventory breakdowns and real-time transit maps.
- **Tablet (768px - 1199px):** 8 columns, `1rem` (`16px`) gutters, `1.5rem` (`24px`) margins. Sidebar transforms into an overlay sheet; KPI grids reflow into 2-column configurations.
- **Mobile (< 768px):** 4 columns, `1rem` (`16px`) gutters, `1rem` (`16px`) canvas margins. Complex tables shift to swipeable cards or horizontal scroll drawers with pinned identifier columns.

Vertical cadence relies on an 8px modular baseline. Content density levels inside data grids can be dynamically toggled between Compact (36px row height) and Comfortable (48px row height) while preserving consistent gutter geometry.

## Elevation & Depth

Depth in this design system is understated and pristine, favoring structural borders and ambient tinted shadows over dramatic drop shadows.

- **Level 0 (Flat / Inset):** Filter chips, table header strips, and inactive inputs sit flush against canvas surfaces with a 1px border of `#E2E8F0`.
- **Level 1 (Surface Cards & Panels):** Primary modules, inventory cards, and KPI panels rest on pure white with a 1px outline of `#EDF2F7` and an ambient, cool-tinted shadow: `box-shadow: 0 1px 3px 0 rgba(30, 58, 95, 0.04), 0 1px 2px -1px rgba(30, 58, 95, 0.02)`.
- **Level 2 (Hover & Interactive Focus):** Card hovers and expanded row flyouts use an elevated shadow: `box-shadow: 0 4px 12px -2px rgba(59, 130, 166, 0.08), 0 2px 6px -1px rgba(30, 58, 95, 0.04)`.
- **Level 3 (Overlays, Modals & Menus):** Dropdowns, quick-filters, and slide-over shipment details use a deep ambient shadow: `box-shadow: 0 16px 32px -8px rgba(30, 58, 95, 0.12), 0 4px 12px -2px rgba(30, 58, 95, 0.04)`, layered over an ambient backdrop blur (`backdrop-filter: blur(8px); background-color: rgba(248, 250, 252, 0.8)`).

## Shapes

The system uses a balanced `Rounded` (Level 2) shape language, bringing modern softness while maintaining professional structure.

- Standard buttons, input fields, dropdown triggers, and status badges take a `0.5rem` (`8px`) border radius.
- Cards, modal containers, and dashboard preview panels apply `rounded-lg` at `1rem` (`16px`).
- Floating utility toasts, pill filters, and active SKU tags use a fully pill-shaped profile (`9999px`) to create clear geometric contrast against rectangular data tables.

## Components

### Buttons
- **Primary:** Solid `#3B82A6` with crisp white text, `8px` border radius, and a subtle inset highlight border. On hover, shifts to `#2F6A88`.
- **Secondary:** White background with a 1px `#E2E8F0` border and `#1E3A5F` text. On hover, transitions to a soft powder tint (`#F0F9FF`) with a `#3B82A6` border.
- **Ghost / Tertiary:** Transparent background, `#64748B` label, shifting to `#F1F5F9` on hover.

### Stat Metrics & KPI Panels
- Encased in pure white cards with an optional pastel gradient header band (sky blue to powder blue).
- Features a small label above (`label-sm`, uppercase, `#64748B`), an oversized metric value (`data-metric`, `#1E3A5F`), and an inline status indicator chip displaying positive/negative trends.

### Chips & Status Badges
- Semi-transparent pastel backgrounds paired with deep tonal text for supply chain states:
  - *In Transit:* `#E0F2FE` background, `#0369A1` text.
  - *Delivered / In Stock:* `#ECFDF5` background, `#047857` text.
  - *Low Stock / Delayed:* `#FEF3C7` background, `#B45309` text.
  - *Critical Out of Stock:* `#FEE2E2` background, `#B91C1C` text.
- Height is fixed at 24px, padding is `0 8px`, with an `Inter` font weight of 600 at 11px.

### Input Fields & Search Bars
- Background of `#FFFFFF` with a 1px border of `#CBD5E1`.
- Focus state features a crisp outer ring: `0 0 0 3px rgba(125, 211, 252, 0.4)` and a `#3B82A6` border.
- Global SKU / Asset search includes a fixed left-aligned icon, subtle keyboard shortcut token (`⌘K`), and placeholder text styled in `#94A3B8`.

### Checkboxes & Radio Buttons
- Checkboxes feature an 8px rounded profile (`rounded-sm`), 1.5px border in `#CBD5E1`. When selected, filled with `#3B82A6` with an etched white checkmark.
- Radio indicators follow the same palette with a nested solid dot.

### Data Tables
- Header row styled in `#F8FAFC` with uppercase `Inter` labels (`11px`, `#64748B`).
- Clean horizontal borders in `#F1F5F9`; vertical borders are omitted to minimize visual noise.
- Row hover triggers an ultra-soft tint of `#F0F9FF`.