---
name: Astro Logistics & Supply Engine
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
  on-surface-variant: '#424653'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#737785'
  outline-variant: '#c3c6d6'
  surface-tint: '#0958ca'
  primary: '#00429d'
  on-primary: '#ffffff'
  primary-container: '#0a58ca'
  on-primary-container: '#ccd8ff'
  inverse-primary: '#b0c6ff'
  secondary: '#006398'
  on-secondary: '#ffffff'
  secondary-container: '#5bb8fe'
  on-secondary-container: '#00476e'
  tertiary: '#3f465c'
  on-tertiary: '#ffffff'
  tertiary-container: '#565e74'
  on-tertiary-container: '#d0d8f2'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#d9e2ff'
  primary-fixed-dim: '#b0c6ff'
  on-primary-fixed: '#001945'
  on-primary-fixed-variant: '#00419d'
  secondary-fixed: '#cce5ff'
  secondary-fixed-dim: '#93ccff'
  on-secondary-fixed: '#001d31'
  on-secondary-fixed-variant: '#004b73'
  tertiary-fixed: '#dae2fd'
  tertiary-fixed-dim: '#bec6e0'
  on-tertiary-fixed: '#131b2e'
  on-tertiary-fixed-variant: '#3f465c'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  headline-xl:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.015em
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
    letterSpacing: -0.01em
  headline-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  body-sm:
    fontFamily: Inter
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
    letterSpacing: 0.04em
  mono-data:
    fontFamily: JetBrains Mono
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: -0.01em
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  gutter: 1rem
  gutter-dense: 0.5rem
  margin: 1.5rem
  margin-compact: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 0.75rem
  space-lg: 1.25rem
  space-xl: 1.75rem
---

## Brand & Style

The brand personality focuses on operational precision, uncompromising velocity, and structural clarity. Designed specifically for high-throughput enterprise logistics directors, floor dispatchers, and inventory controllers, the interface conveys reliability, high visibility, and frictionless control across massive supply chains.

The visual style is **Corporate / Modern High-Density**:
- High-efficiency spatial distribution engineered for dense desktop workstations.
- Clean architectural lines, razor-sharp edge contrast, and micro-deliberate structural dividers.
- Crisp white workspaces elevated by clinical corporate blues and precise data visualization markers.
- Minimal visual noise to reduce operational cognitive fatigue during sustained 8-to-12-hour terminal usage.

## Colors

The palette leverages high-contrast corporate blues against crystalline white and slate canvas layers.

### Role Assignments
- **Primary (`#0A58CA`)**: Authoritative logistics blue. Applied strictly to primary actions, selected navigation items, key active state indicators, and major progress milestones.
- **Secondary (`#0284C7`)**: High-visibility sky blue. Used for interactive hover states, secondary highlights, sorting indicators, and inbound movement tags.
- **Tertiary (`#0F172A`)**: Deep structural slate. Governs top-tier typography, primary structural headers, and dark persistent sidebars.
- **Neutral (`#64748B` with tint scale)**: Systematic utilitarian grays. Used for structural borders (`#E2E8F0`), secondary metadata (`#64748B`), and dense table alternating rows (`#F8FAFC`).
- **Canvas Base (`#FFFFFF` & `#F8FAFC`)**: Canvas base is `#F8FAFC`, while elevated workspace surfaces, sheets, and active metric cards use `#FFFFFF`.

### Status & Logistics Semantic Tokens
- **Inbound Movement**: Fill `#E0F2FE`, Text & Border `#0284C7`.
- **Outbound Movement**: Fill `#EDE9FE`, Text & Border `#6366F1`.
- **Status: Approved**: Fill `#ECFDF5`, Text & Border `#059669`.
- **Status: Pending**: Fill `#FFFBEB`, Text & Border `#D97706`.
- **Status: Rejected / Discrepancy**: Fill `#FEF2F2`, Text & Border `#DC2626`.

## Typography

Typography prioritizes scanning speed and numeric legibility.

- **Headlines (Plus Jakarta Sans)**: Used for high-level screen titles, modal headers, and key analytic card numbers. Delivers modern structure with authoritative presence.
- **Body & Labels (Inter)**: Handles inventory listings, operational inputs, system feedback, and high-density interface controls with clear neutral glyphs.
- **Data & SKU Font (JetBrains Mono)**: Applied explicitly to SKUs, barcode values, batch numbers, bin coordinates, timestamps, and inventory balance counts to ensure alignment and prevent character confusion (e.g., `0` vs `O`, `1` vs `l`).

## Layout & Spacing

A desktop-first layout engine optimized for screen viewports between 1280px and 2560px.

### Layout Model
- **Grid Architecture**: 12-column fluid grid system across operational workspaces, supported by an anchor rail navigation pattern (fixed 240px expanded / 64px collapsed).
- **Desktop Rhythm**: Standard 16px (`1rem`) column gutters with 24px (`1.5rem`) outer canvas padding. High-density sub-views (e.g., bin-rack visualizers and SKU matching grids) switch to `gutter-dense` (8px).
- **Breakpoint Rules**:
  - `Desktop Wide (>= 1600px)`: Full 12-column layout with split table-and-side-sheet inspect panels without row occlusions.
  - `Desktop Standard (1280px - 1599px)`: 12 columns; inspect sheets slide over table view with backdrop-blur overlay.
  - `Tablet / Field Device (< 1280px)`: Sidebar collapses strictly to icon rail, multi-metric ribbons wrap to 2x2 grids, and tables drop auxiliary metadata columns.

## Elevation & Depth

Visual hierarchy is maintained via **low-contrast outlines** paired with **ambient micro-shadows**, ensuring clarity across multi-window operational workflows.

- **Level 0 (Flat Canvas)**: Hex `#F8FAFC` base background.
- **Level 1 (Card / Table Containers)**: Solid `#FFFFFF` background with a crisp border `1px solid #E2E8F0`. Shadow: `0 1px 2px 0 rgba(15, 23, 42, 0.04)`.
- **Level 2 (Popovers / Dropdowns / Quick Filter Menus)**: `#FFFFFF` surface, border `1px solid #CBD5E1`. Shadow: `0 4px 6px -1px rgba(15, 23, 42, 0.08), 0 2px 4px -2px rgba(15, 23, 42, 0.05)`.
- **Level 3 (Drawer / Side Inspection Sheets / Dialogs)**: `#FFFFFF` surface, border `1px solid #94A3B8`. Shadow: `0 20px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.08)`.

## Shapes

The design system uses **Soft (Level 1)** shaping to preserve a clean, industrial, and high-density presentation:
- Base controls (buttons, inputs, select triggers, table cells): `0.25rem` (4px).
- Containers (metric cards, high-density data tables, modal dialogs): `0.5rem` (8px).
- Flyout panels and full sheets: `0.75rem` (12px) max on detached corners.
- Badges and status pills: strict exception using full pill radius (`9999px`) to create rapid visual differentiation against angular data tables.

## Components

### Buttons
- **Primary**: Solid `#0A58CA` background, `#FFFFFF` text, `4px` radius, height `36px` (desktop compact). Hover: `#084298`. Active: `#063275`.
- **Secondary / Outlined**: `#FFFFFF` background, `1px solid #CBD5E1`, text `#0F172A`. Hover: `#F8FAFC` background with border `#94A3B8`.
- **Destructive**: `#DC2626` background, white text. For scrap, delete SKU, and critical inventory adjustments.

### Input Fields & Sleek Search Bars
- Standard text input height is `36px` with `4px` border radius, padding `0 12px`, border `1px solid #CBD5E1`, text `#0F172A`, placeholder `#94A3B8`. Focus: `1px solid #0A58CA` with `0 0 0 2px rgba(10, 88, 202, 0.15)` ring.
- **Warehouse Global Search Bar**: Prominent `40px` height with integrated shortcut pill (`⌘K` / `Ctrl+K`), left-aligned magnifying icon (`#64748B`), clear input button, and hot-key bin scanning mode toggle.

### High-Density Data Tables
- Row height: strictly `40px` for high-density mode (option to toggle to `48px` standard).
- Header: `#F8FAFC` background, text `#475569`, font size `11px`, bold uppercase, letter spacing `0.04em`, bottom border `1px solid #CBD5E1`.
- Rows: `#FFFFFF` alternate with `#FAFAFA` (striped option), bottom border `1px solid #F1F5F9`. Hover state: `#F1F5F9` across the entire row with a left border highlight of `2px solid #0A58CA`.
- Numeric and coordinate fields (SKU, Qty, Bin location) must strictly align right and render in `JetBrains Mono`.

### Inventory Status Badges & Chips
- Structure: height `22px`, font size `11px`, font weight `600`, letter-spacing `0.02em`, pill-shaped (`9999px`), inline-flex alignment with micro status-dot (`6px` diameter).
- **Inbound**: Background `#E0F2FE`, border `#BAE6FD`, text `#0369A1`.
- **Outbound**: Background `#EDE9FE`, border `#DDD6FE`, text `#5B21B6`.
- **Approval Pending**: Background `#FEF3C7`, border `#FDE68A`, text `#92400E`.
- **Approval Approved**: Background `#DCFCE7`, border `#BBF7D0`, text `#166534`.
- **Approval Rejected**: Background `#FEE2E2`, border `#FECACA`, text `#991B1B`.

### Quick Metric Cards
- Background `#FFFFFF`, border `1px solid #E2E8F0`, padding `16px`, radius `8px`.
- Visual structure: Top row contains micro-label (`12px`, `#64748B`, uppercase) and trend indicator chip (`+4.2% vs yesterday`). Center contains hero metric value (`28px`, `Plus Jakarta Sans`, bold, `#0F172A`). Bottom contains secondary metric description or progress bar showing warehouse capacity fill.

### Checkboxes & Selection Controls
- Size: `16px` by `16px` square with `3px` corner radius.
- Unchecked: `1px solid #94A3B8`, background `#FFFFFF`.
- Checked: `#0A58CA` background, `#FFFFFF` check icon.
- Indeterminate state: `#0A58CA` background with white center horizontal bar for bulk table row selection.