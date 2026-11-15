<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan &amp; Analitik Inventaris | Astro Inventory</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Ikon sidebar & topbar: komponen Blade (sidebar/navbar) memakai Font Awesome 6.
         Sebelumnya stylesheet ini belum dimuat sehingga semua ikon menu tidak tampil. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Font Inter untuk teks antarmuka -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide dimuat langsung (bukan lazy) supaya ikon konten tidak hilang saat CDN lambat -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>document.documentElement.classList.add('ai-js');</script>

    <style>
/* ==== Astro Inventory design system (inlined) ==== */
/* ============================================================
   Astro Inventory — Shared styles (design system)
   ============================================================ */

:root {
  --brand: #2563eb;
  --brand-dark: #1d4ed8;
  --bg: #f5f7fb;
  --line: #e7ebf2;
}

html {
  scroll-behavior: smooth;
}

body {
  font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
  background: var(--bg);
  color: #172033;
  -webkit-font-smoothing: antialiased;
}

/* ---------- Scrollbar ---------- */
::-webkit-scrollbar {
  width: 9px;
  height: 9px;
}
::-webkit-scrollbar-track {
  background: transparent;
}
::-webkit-scrollbar-thumb {
  background: #cdd6e4;
  border-radius: 99px;
  border: 2px solid #f5f7fb;
}
::-webkit-scrollbar-thumb:hover {
  background: #aab8cf;
}

/* ---------- Cards ---------- */
.ai-card {
  background: #fff;
  border: 1px solid var(--line);
  border-radius: 16px;
  box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
  transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.25s;
}
.ai-card-hover:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 28px -12px rgba(37, 99, 235, 0.22), 0 4px 10px rgba(15, 23, 42, 0.06);
}

/* ---------- Buttons ---------- */
.ai-btn {
  position: relative;
  overflow: hidden;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  font-weight: 600;
  font-size: 13px;
  border-radius: 10px;
  padding: 10px 16px;
  transition: all 0.18s ease;
  cursor: pointer;
  white-space: nowrap;
}
.ai-btn:active {
  transform: scale(0.97);
}
.ai-btn-primary {
  background: var(--brand);
  color: #fff;
  box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.5);
}
.ai-btn-primary:hover {
  background: var(--brand-dark);
  box-shadow: 0 8px 18px -6px rgba(37, 99, 235, 0.55);
  transform: translateY(-1px);
}
.ai-btn-secondary {
  background: #fff;
  color: #334155;
  border: 1px solid #dbe2ec;
}
.ai-btn-secondary:hover {
  background: #f8fafc;
  border-color: #c3cfe0;
  transform: translateY(-1px);
}
.ai-btn-soft {
  background: #eff6ff;
  color: var(--brand-dark);
}
.ai-btn-soft:hover {
  background: #dbeafe;
}
.ai-btn-danger {
  background: #fef2f2;
  color: #dc2626;
}
.ai-btn-danger:hover {
  background: #fee2e2;
}

/* Ripple */
.ai-ripple {
  position: absolute;
  border-radius: 9999px;
  transform: scale(0);
  animation: ai-ripple 0.6s ease-out;
  background: rgba(255, 255, 255, 0.45);
  pointer-events: none;
}
.ai-btn-secondary .ai-ripple,
.ai-btn-soft .ai-ripple,
.ai-btn-danger .ai-ripple {
  background: rgba(37, 99, 235, 0.18);
}
@keyframes ai-ripple {
  to {
    transform: scale(2.6);
    opacity: 0;
  }
}

/* ---------- Entrance animations ---------- */
/* Animasi masuk hanya aktif bila JS berjalan (html.ai-js).
   Tanpa JS / jika skrip gagal, konten tetap terlihat (tidak blank). */
.ai-reveal {
  opacity: 1;
}
.ai-js .ai-reveal {
  opacity: 0;
  transform: translateY(14px);
}
.ai-js .ai-reveal.ai-revealed {
  animation: ai-fade-up 0.55s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}
@keyframes ai-fade-up {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* ---------- Badges & pills ---------- */
.ai-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  border-radius: 999px;
  padding: 3px 10px;
  font-size: 11px;
  font-weight: 700;
  white-space: nowrap;
}

/* ---------- Live dot ---------- */
.ai-live-dot {
  width: 8px;
  height: 8px;
  border-radius: 999px;
  background: #16a34a;
  position: relative;
  flex: none;
}
.ai-live-dot::after {
  content: "";
  position: absolute;
  inset: -4px;
  border-radius: 999px;
  background: rgba(22, 163, 74, 0.35);
  animation: ai-pulse 1.8s ease-out infinite;
}
@keyframes ai-pulse {
  0% {
    transform: scale(0.5);
    opacity: 1;
  }
  100% {
    transform: scale(1.6);
    opacity: 0;
  }
}

/* ---------- Progress bars ---------- */
.ai-bar {
  height: 6px;
  border-radius: 999px;
  background: #e8edf5;
  overflow: hidden;
}
.ai-bar > span {
  display: block;
  height: 100%;
  border-radius: 999px;
  width: 0;
  transition: width 1.1s cubic-bezier(0.22, 1, 0.36, 1);
}

/* ---------- Toast ---------- */
#ai-toast-root {
  position: fixed;
  z-index: 9999;
  right: 20px;
  bottom: 20px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.ai-toast {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #fff;
  border: 1px solid var(--line);
  border-left: 4px solid var(--brand);
  border-radius: 12px;
  box-shadow: 0 14px 34px -12px rgba(15, 23, 42, 0.28);
  padding: 12px 16px;
  font-size: 13px;
  font-weight: 600;
  color: #243044;
  min-width: 260px;
  max-width: 380px;
  animation: ai-toast-in 0.35s cubic-bezier(0.22, 1, 0.36, 1);
}
.ai-toast.ai-toast-success {
  border-left-color: #16a34a;
}
.ai-toast.ai-toast-danger {
  border-left-color: #dc2626;
}
.ai-toast.ai-toast-warn {
  border-left-color: #d97706;
}
.ai-toast.ai-toast-out {
  animation: ai-toast-out 0.3s ease forwards;
}
@keyframes ai-toast-in {
  from {
    opacity: 0;
    transform: translateX(40px) scale(0.95);
  }
}
@keyframes ai-toast-out {
  to {
    opacity: 0;
    transform: translateX(40px) scale(0.95);
  }
}

/* ---------- Modal ---------- */
.ai-modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 9998;
  background: rgba(15, 23, 42, 0.45);
  backdrop-filter: blur(3px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  opacity: 0;
  transition: opacity 0.22s ease;
}
.ai-modal-overlay.ai-open {
  opacity: 1;
}
.ai-modal {
  background: #fff;
  border-radius: 18px;
  width: 100%;
  max-width: 560px;
  box-shadow: 0 30px 70px -20px rgba(15, 23, 42, 0.4);
  transform: translateY(22px) scale(0.97);
  transition: transform 0.28s cubic-bezier(0.22, 1, 0.36, 1);
  max-height: 88vh;
  overflow: auto;
}
.ai-modal-overlay.ai-open .ai-modal {
  transform: translateY(0) scale(1);
}

/* ---------- Tables ---------- */
.ai-table th {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: #64748b;
  background: #f8fafc;
  padding: 12px 14px;
  white-space: nowrap;
}
.ai-table td {
  padding: 13px 14px;
  font-size: 13px;
  vertical-align: middle;
}
.ai-table tbody tr {
  transition: background 0.15s;
}
.ai-table tbody tr:hover {
  background: #f6f9ff;
}

/* ---------- Tabs / pills ---------- */
.ai-pill {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  border-radius: 999px;
  padding: 8px 15px;
  font-size: 12.5px;
  font-weight: 600;
  color: #475569;
  background: #fff;
  border: 1px solid #e2e8f0;
  cursor: pointer;
  transition: all 0.18s ease;
  white-space: nowrap;
}
.ai-pill:hover {
  border-color: #93c5fd;
  color: var(--brand-dark);
  transform: translateY(-1px);
}
.ai-pill.ai-pill-active {
  background: var(--brand);
  border-color: var(--brand);
  color: #fff;
  box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.5);
}

/* ---------- Inputs ---------- */
.ai-input {
  width: 100%;
  border: 1px solid #dbe2ec;
  border-radius: 10px;
  padding: 10px 13px;
  background: #fff;
  color: #243044;
  outline: none;
  font-size: 13px;
  transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
}
.ai-input:focus {
  border-color: var(--brand);
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.13);
}
.ai-input::placeholder {
  color: #94a3b8;
}

/* ---------- Toggle switch ---------- */
.ai-switch {
  width: 46px;
  height: 26px;
  border-radius: 999px;
  background: #cbd5e1;
  position: relative;
  cursor: pointer;
  transition: background 0.22s;
  flex: none;
}
.ai-switch::after {
  content: "";
  position: absolute;
  top: 3px;
  left: 3px;
  width: 20px;
  height: 20px;
  border-radius: 999px;
  background: #fff;
  box-shadow: 0 1px 4px rgba(15, 23, 42, 0.25);
  transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.ai-switch.ai-on {
  background: var(--brand);
}
.ai-switch.ai-on::after {
  transform: translateX(20px);
}

/* ---------- Dropdown menu ---------- */
.ai-menu {
  position: absolute;
  right: 0;
  top: calc(100% + 8px);
  background: #fff;
  border: 1px solid var(--line);
  border-radius: 14px;
  box-shadow: 0 18px 40px -14px rgba(15, 23, 42, 0.25);
  min-width: 240px;
  padding: 8px;
  z-index: 200;
  opacity: 0;
  transform: translateY(-8px) scale(0.98);
  pointer-events: none;
  transition: all 0.2s cubic-bezier(0.22, 1, 0.36, 1);
}
.ai-menu.ai-open {
  opacity: 1;
  transform: translateY(0) scale(1);
  pointer-events: auto;
}
.ai-menu-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 11px;
  border-radius: 9px;
  font-size: 13px;
  font-weight: 500;
  color: #334155;
  cursor: pointer;
  transition: background 0.14s;
  width: 100%;
  text-align: left;
}
.ai-menu-item:hover {
  background: #f1f5f9;
  color: var(--brand-dark);
}

/* ---------- Notification pop ---------- */
@keyframes ai-bell-ring {
  0%, 25%, 55%, 100% {
    transform: rotate(0);
  }
  10% {
    transform: rotate(14deg);
  }
  20% {
    transform: rotate(-10deg);
  }
  40% {
    transform: rotate(8deg);
  }
}
.ai-bell-ring {
  animation: ai-bell-ring 1.4s ease;
  transform-origin: top center;
}

/* ---------- Misc ---------- */
.ai-shimmer {
  background: linear-gradient(100deg, transparent 30%, rgba(255, 255, 255, 0.55) 50%, transparent 70%);
  background-size: 220% 100%;
  animation: ai-shimmer 2.6s infinite;
}
@keyframes ai-shimmer {
  from {
    background-position: 180% 0;
  }
  to {
    background-position: -80% 0;
  }
}
.ai-clickable {
  cursor: pointer;
  transition: background 0.15s, transform 0.15s;
}
.ai-clickable:hover {
  background: #f8fafc;
}
    /* ---------- Sidebar (komponen Blade: components/sidebar.blade.php) ---------- */
    .nav-link {
        transition: all 0.16s ease;
    }
    .nav-link:hover {
        background: #f1f5f9;
        color: #172033;
        transform: translateX(3px);
    }
    .nav-link.active {
        background: var(--brand);
        color: #fff;
        font-weight: 600;
        box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55);
    }
    .nav-link.active:hover {
        transform: none;
        background: var(--brand);
    }

    /* ---------- Fokus keyboard yang jelas ---------- */
    a:focus-visible,
    button:focus-visible,
    select:focus-visible,
    input:focus-visible {
        outline: 2px solid var(--brand);
        outline-offset: 2px;
    }

    /* ---------- Empty state panel tab ---------- */
    .ai-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 42px 24px;
        text-align: center;
    }
    .ai-empty-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: var(--brand);
        margin-bottom: 4px;
    }

    /* ---------- Hormati preferensi "kurangi animasi" ---------- */
    @media (prefers-reduced-motion: reduce) {
        .ai-js .ai-reveal,
        .ai-js .ai-reveal.ai-revealed {
            opacity: 1;
            transform: none;
            animation: none;
        }
        .ai-card,
        .ai-card-hover:hover,
        .nav-link:hover,
        .ai-pill:hover {
            transition: none;
            transform: none;
        }
    }
    </style>

    <script>
/* ==== Astro Inventory shell & interaksi (inlined) ==== */
/* ============================================================
   Astro Inventory — Shared shell (sidebar + topbar) & interaksi
   Dipakai semua halaman. Halaman cukup set:
   <body data-role="superadmin|pegawai" data-active="dashboard" ...>
   ============================================================ */
(function () {
  "use strict";

  /* ---------------- Tailwind config ---------------- */
  window.tailwind = window.tailwind || {};
  window.tailwind.config = {
    theme: {
      extend: {
        colors: {
          brand: { DEFAULT: "#2563eb", dark: "#1d4ed8", 50: "#eff6ff", 100: "#dbeafe", 600: "#2563eb", 700: "#1d4ed8" },
        },
        fontFamily: { sans: ["Inter", "ui-sans-serif", "system-ui", "sans-serif"] },
      },
    },
  };

  /* ---------------- Google Fonts + Lucide ---------------- */
  function addLink(id, href) {
    if (document.getElementById(id)) return;
    var l = document.createElement("link");
    l.id = id; l.rel = "stylesheet"; l.href = href;
    document.head.appendChild(l);
  }
  addLink("ai-font", "https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap");

  window.aiIcons = function () {
    if (window.lucide && window.lucide.createIcons) window.lucide.createIcons();
  };
  function loadLucide(cb) {
    if (window.lucide) { cb(); return; }
    var s = document.createElement("script");
    s.src = "https://unpkg.com/lucide@latest/dist/umd/lucide.min.js";
    s.onload = cb;
    /* fallback: coba CDN alternatif bila unpkg diblokir/lambat */
    s.onerror = function () {
      var alt = document.createElement("script");
      alt.src = "https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js";
      alt.onload = cb;
      document.head.appendChild(alt);
    };
    document.head.appendChild(s);
  }


  function el(html) {
    var t = document.createElement("template");
    t.innerHTML = html.trim();
    return t.content.firstElementChild;
  }

  /* ---------------- Breadcrumb ---------------- */
  function buildBreadcrumb(node) {
    var data = [];
    try { data = JSON.parse(node.getAttribute("data-breadcrumb") || "[]"); } catch (e) {}
    var html = data.map(function (b, i) {
      var last = i === data.length - 1;
      return (i > 0 ? '<i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>' : "") +
        '<span class="' + (last ? "text-blue-600 font-bold" : "text-slate-400 font-semibold") + '">' + b.label + "</span>";
    }).join("");
    var nav = el('<nav class="flex items-center gap-1.5 text-[11px] tracking-[0.04em] uppercase mb-2">' + html + "</nav>");
    node.replaceWith(nav);
  }

  /* ---------------- Toast ---------------- */
  function toastRoot() {
    var root = document.getElementById("ai-toast-root");
    if (!root) {
      root = el('<div id="ai-toast-root"></div>');
      document.body.appendChild(root);
    }
    return root;
  }
  window.aiToast = function (msg, type, icon) {
    var icons = { success: "check-circle-2", danger: "alert-triangle", warn: "alert-circle", info: "info" };
    var colors = { success: "text-emerald-600", danger: "text-red-600", warn: "text-amber-600", info: "text-blue-600" };
    var t = el(
      '<div class="ai-toast ' + (type ? "ai-toast-" + type : "") + '">' +
      '<i data-lucide="' + (icons[type] || icons.info) + '" class="w-[18px] h-[18px] flex-none ' + (colors[type] || colors.info) + '"></i>' +
      "<span>" + msg + "</span></div>"
    );
    toastRoot().appendChild(t);
    window.aiIcons();
    setTimeout(function () {
      t.classList.add("ai-toast-out");
      setTimeout(function () { t.remove(); }, 320);
    }, 3200);
  };

  /* ---------------- Count-up ---------------- */
  function animateCount(elm) {
    var target = parseFloat((elm.getAttribute("data-count") || "0").replace(/\./g, "").replace(",", "."));
    var decimals = parseInt(elm.getAttribute("data-decimals") || "0", 10);
    var duration = parseInt(elm.getAttribute("data-duration") || "1200", 10);
    var start = null;
    function fmt(v) {
      var s = v.toFixed(decimals);
      var parts = s.split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      return parts.join(",");
    }
    function step(ts) {
      if (!start) start = ts;
      var p = Math.min((ts - start) / duration, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      elm.textContent = fmt(target * eased);
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  /* ---------------- Ripple ---------------- */
  function addRipple(e) {
    var btn = e.currentTarget;
    var r = btn.getBoundingClientRect();
    var d = Math.max(r.width, r.height);
    var s = document.createElement("span");
    s.className = "ai-ripple";
    s.style.width = s.style.height = d + "px";
    s.style.left = (e.clientX - r.left - d / 2) + "px";
    s.style.top = (e.clientY - r.top - d / 2) + "px";
    btn.appendChild(s);
    setTimeout(function () { s.remove(); }, 650);
  }

  /* ---------------- Reveal on scroll ---------------- */
  function initReveal() {
    var els = document.querySelectorAll(".ai-reveal:not(.ai-revealed)");
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) {
          var delay = parseInt(en.target.getAttribute("data-delay") || "0", 10);
          setTimeout(function () { en.target.classList.add("ai-revealed"); }, delay);
          io.unobserve(en.target);
        }
      });
    }, { threshold: 0.08 });
    els.forEach(function (e) { io.observe(e); });
  }

  /* ---------------- Bars ---------------- */
  function initBars() {
    document.querySelectorAll(".ai-bar[data-w]").forEach(function (b) {
      b.querySelector("span").style.width = (b.getAttribute("data-w") || 0) + "%";
    });
  }

  /* ---------------- Tabs (pills) ---------------- */
  function initTabs(root) {
    (root || document).querySelectorAll("[data-tabs]").forEach(function (group) {
      var pills = group.querySelectorAll("[data-tab]");
      pills.forEach(function (pill) {
        if (pill.__aiTab) return;
        pill.__aiTab = true;
        /* Navigasi tab via keyboard (panah kiri/kanan) */
        pill.addEventListener("keydown", function (e) {
          if (e.key !== "ArrowRight" && e.key !== "ArrowLeft") return;
          e.preventDefault();
          var list = Array.prototype.slice.call(pills);
          var idx = list.indexOf(pill);
          var next = e.key === "ArrowRight"
            ? list[(idx + 1) % list.length]
            : list[(idx - 1 + list.length) % list.length];
          next.focus();
          next.click();
        });
        pill.addEventListener("click", function () {
          pills.forEach(function (p) {
            p.classList.remove("ai-pill-active");
            p.setAttribute("aria-selected", "false");
          });
          pill.classList.add("ai-pill-active");
          pill.setAttribute("aria-selected", "true");
          var name = pill.getAttribute("data-tab");
          document.querySelectorAll('[data-tabpanel="' + group.getAttribute("data-tabs") + '"]').forEach(function (panel) {
            var match = panel.getAttribute("data-panel-name") === name;
            panel.style.display = match ? "" : "none";
            if (match) { panel.classList.remove("ai-revealed"); panel.classList.add("ai-revealed"); }
          });
          group.dispatchEvent(new CustomEvent("ai:tabchange", { detail: { tab: name }, bubbles: true }));
        });
      });

      /* Tombol "Kembali ke Overview" di dalam panel empty state */
      document.querySelectorAll("[data-tab-target]").forEach(function (btn) {
        if (btn.__aiTabTarget) return;
        btn.__aiTabTarget = true;
        btn.addEventListener("click", function () {
          var target = btn.getAttribute("data-tab-target");
          var pill = group.querySelector('[data-tab="' + target + '"]');
          if (pill) pill.click();
        });
      });
    });
  }

  /* ---------------- Modal ---------------- */
  window.aiModal = {
    open: function (id) {
      var m = document.getElementById(id);
      if (!m) return;
      m.classList.add("ai-open");
      document.body.style.overflow = "hidden";
    },
    close: function (id) {
      var m = document.getElementById(id);
      if (!m) return;
      m.classList.remove("ai-open");
      document.body.style.overflow = "";
    },
  };

  /* ---------------- Boot ---------------- */
  function boot() {
    document.querySelectorAll("[data-breadcrumb]").forEach(buildBreadcrumb);

    /* ctrl/cmd + K search */
    document.addEventListener("keydown", function (e) {
      if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === "k") {
        e.preventDefault();
        var s = document.getElementById("ai-search");
        if (s) s.focus();
      }
      if (e.key === "Escape") { document.querySelectorAll(".ai-modal-overlay.ai-open").forEach(function (m) { window.aiModal.close(m.id); }); }
    });

    /* data-toast buttons */
    document.querySelectorAll("[data-toast]").forEach(function (b) {
      if (b.__aiToast) return;
      b.__aiToast = true;
      b.addEventListener("click", function () {
        window.aiToast(b.getAttribute("data-toast"), b.getAttribute("data-toast-type") || "success");
      });
    });

    /* data-modal buttons */
    document.querySelectorAll("[data-modal-open]").forEach(function (b) {
      b.addEventListener("click", function () { window.aiModal.open(b.getAttribute("data-modal-open")); });
    });
    document.querySelectorAll("[data-modal-close]").forEach(function (b) {
      b.addEventListener("click", function () { window.aiModal.close(b.closest(".ai-modal-overlay").id); });
    });
    document.querySelectorAll(".ai-modal-overlay").forEach(function (m) {
      m.addEventListener("click", function (e) { if (e.target === m) window.aiModal.close(m.id); });
    });

    /* ripples on buttons */
    document.querySelectorAll(".ai-btn, button").forEach(function (b) {
      if (b.__aiRipple) return;
      b.__aiRipple = true;
      b.addEventListener("click", addRipple);
    });

    /* switches */
    document.querySelectorAll(".ai-switch").forEach(function (sw) {
      if (sw.__aiSwitch) return;
      sw.__aiSwitch = true;
      sw.addEventListener("click", function () {
        sw.classList.toggle("ai-on");
        sw.dispatchEvent(new CustomEvent("ai:switch", { detail: { on: sw.classList.contains("ai-on") }, bubbles: true }));
      });
    });

    initTabs();
    initBars();

    /* counts (immediate + on reveal) */
    document.querySelectorAll("[data-count]").forEach(function (c) {
      if (c.__aiCount) return;
      c.__aiCount = true;
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting) { animateCount(en.target); io.unobserve(en.target); }
        });
      }, { threshold: 0.4 });
      io.observe(c);
    });

    initReveal();
    loadLucide(function () { window.aiIcons(); });
  }

  /* Jaring aman: bila ada error JS/CDN, konten .ai-reveal jangan sampai tetap tersembunyi */
  function safeRevealAll() {
    document.querySelectorAll(".ai-reveal:not(.ai-revealed)").forEach(function (e) {
      e.classList.add("ai-revealed");
    });
  }
  window.addEventListener("error", safeRevealAll);
  window.addEventListener("unhandledrejection", safeRevealAll);

  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
  else boot();

  /* re-init untuk konten dinamis */
  window.aiRefresh = function () {
    document.querySelectorAll("[data-toast]").forEach(function (b) {
      if (!b.__aiToast) { b.__aiToast = true; b.addEventListener("click", function () { window.aiToast(b.getAttribute("data-toast"), b.getAttribute("data-toast-type") || "success"); }); }
    });
    document.querySelectorAll(".ai-btn, button").forEach(function (b) {
      if (!b.__aiRipple) { b.__aiRipple = true; b.addEventListener("click", addRipple); }
    });
    initTabs(); initBars(); initReveal(); window.aiIcons();
  };
})();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="min-h-screen bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <!-- Main Content -->
    <main id="ai-main" class="flex-1 overflow-x-hidden px-4 md:px-7 py-5 space-y-5">

        {{-- ================= SUPER ADMIN ================= --}}
        @if(auth()->user()->isSuperAdmin())

        <!-- ===== Breadcrumb strip ===== -->
        <div class="flex flex-wrap items-center justify-between gap-3">
          <div data-breadcrumb='[{"label":"MANAJEMEN SISTEM"},{"label":"LAPORAN & ANALITIK"}]'></div>
        </div>

        <!-- ===== Header card ===== -->
        <section class="ai-card ai-card-hover ai-reveal p-6">
          <div class="flex flex-col xl:flex-row xl:items-center gap-5 justify-between">
            <div class="max-w-2xl">
              <h1 class="text-[24px] font-extrabold text-slate-800 leading-tight">
                Laporan &amp; Analitik Inventaris <span class="text-[13px] font-semibold text-slate-400">(Operational Intelligence)</span>
              </h1>
              <p class="mt-2 text-[13px] text-slate-500 leading-relaxed">Analisis perputaran persediaan (inventory turnover), pergerakan arus barang inbound/outbound, akurasi stok opname, serta efisiensi kapasitas rak Hub Cakung DC-01.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5 flex-none">
              <button class="ai-btn ai-btn-secondary" data-toast="Periode: 30 Hari Terakhir (1 Feb - 2 Mar 2025)" data-toast-type="info">
                <i data-lucide="calendar" class="w-4 h-4"></i>30 Hari Terakhir (1 Feb - 2 Mar 2025)<i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
              </button>
              <button class="ai-btn ai-btn-secondary" data-toast="Laporan analitik diekspor (PDF/XLSX)">
                <i data-lucide="download" class="w-4 h-4"></i>Export Laporan
              </button>
              <button class="ai-btn ai-btn-primary" data-toast="Builder Analisis Kustom dibuka" data-toast-type="info">
                <i data-lucide="plus" class="w-4 h-4"></i>Buat Analisis Kustom
              </button>
            </div>
          </div>
        </section>

        <!-- ===== KPI cards ===== -->
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="0">
            <div class="flex items-start justify-between">
              <div class="text-[13px] font-bold text-slate-600">Inventory Turnover Ratio (ITR)</div>
              <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-none"><i data-lucide="refresh-cw" class="w-[18px] h-[18px] text-blue-600"></i></div>
            </div>
            <div class="mt-3 flex items-baseline gap-1.5">
              <span class="text-[32px] font-extrabold text-slate-800 leading-none" data-count="6.8" data-decimals="1">0</span>
              <span class="text-[18px] font-extrabold text-slate-800">x</span>
              <span class="text-[11.5px] text-slate-400 font-medium ml-1">Annualized</span>
            </div>
            <div class="mt-4 flex items-center justify-between gap-2 rounded-xl bg-slate-50 border border-slate-100 px-3 py-2">
              <span class="text-[11px] font-semibold text-slate-500">Target SLA: &ge; 6.0x / Thn</span>
              <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="trending-up" class="w-3 h-3"></i>+0.6x Q4 '24</span>
            </div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="80">
            <div class="flex items-start justify-between">
              <div class="text-[13px] font-bold text-slate-600">Total Valuasi Stok Aktif</div>
              <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-none"><i data-lucide="wallet" class="w-[18px] h-[18px] text-blue-600"></i></div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
              <span class="text-[32px] font-extrabold text-slate-800 leading-none">Rp <span data-count="4.82" data-decimals="2">0</span> M</span>
              <span class="text-[11.5px] text-slate-400 font-medium">Asset Value</span>
            </div>
            <div class="mt-4 flex items-center justify-between gap-2 rounded-xl bg-slate-50 border border-slate-100 px-3 py-2">
              <span class="text-[11px] font-semibold text-slate-500">32.450 Fisik &bull; 1.240 SKU</span>
              <span class="ai-badge bg-blue-50 text-blue-700">98.4% Terisi</span>
            </div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="160">
            <div class="flex items-start justify-between">
              <div class="text-[13px] font-bold text-slate-600">Throughput Outbound/Bln</div>
              <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-none"><i data-lucide="arrow-right-left" class="w-[18px] h-[18px] text-blue-600"></i></div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
              <span class="text-[32px] font-extrabold text-slate-800 leading-none" data-count="14280">0</span>
              <span class="text-[11.5px] text-slate-400 font-medium">Qty / Bln</span>
            </div>
            <div class="mt-4 flex items-center justify-between gap-2 rounded-xl bg-slate-50 border border-slate-100 px-3 py-2">
              <span class="text-[11px] font-semibold text-slate-500">In: 12.410 &bull; Out: 14.280</span>
              <span class="ai-badge bg-emerald-50 text-emerald-700">1.15 : 1 Net Outflow</span>
            </div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="240">
            <div class="flex items-start justify-between">
              <div class="text-[13px] font-bold text-slate-600">Akurasi Stok Opname (IRA)</div>
              <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-none"><i data-lucide="shield" class="w-[18px] h-[18px] text-blue-600"></i></div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
              <span class="text-[32px] font-extrabold text-slate-800 leading-none" data-count="99.2" data-decimals="1">0</span>
              <span class="text-[18px] font-extrabold text-slate-800">%</span>
              <span class="text-[11.5px] text-slate-400 font-medium ml-1">High Precision</span>
            </div>
            <div class="mt-4 flex items-center justify-between gap-2 rounded-xl bg-slate-50 border border-slate-100 px-3 py-2">
              <span class="text-[11px] font-semibold text-slate-500">Hasil Siklus Feb 2025</span>
              <span class="ai-badge bg-slate-100 text-slate-600">Selisih &lt; 0.8%</span>
            </div>
          </div>
        </section>

        <!-- ===== Tabs + filter ===== -->
        <section class="ai-card ai-reveal p-4" data-delay="100">
          <div class="flex flex-wrap items-center gap-2">
            <div data-tabs="laporan" class="flex min-w-0 flex-1 gap-2 overflow-x-auto pb-1" role="tablist" aria-label="Jenis laporan analitik">
              <button type="button" role="tab" aria-selected="true" class="ai-pill ai-pill-active" data-tab="semua">Semua Laporan (Overview)</button>
              <button type="button" role="tab" aria-selected="false" class="ai-pill" data-tab="aging">Perputaran &amp; Aging Stok</button>
              <button type="button" role="tab" aria-selected="false" class="ai-pill" data-tab="throughput">Throughput Inbound/Outbound</button>
              <button type="button" role="tab" aria-selected="false" class="ai-pill" data-tab="abc">Klasifikasi ABC &amp; Fast Moving</button>
              <button type="button" role="tab" aria-selected="false" class="ai-pill" data-tab="rak">Kapasitas Rak Gudang</button>
            </div>
            <button type="button" id="resetFilters" class="ai-btn ai-btn-soft flex-none" aria-label="Reset semua filter"><i data-lucide="rotate-ccw" class="w-4 h-4"></i>Reset</button>
          </div>
          <div class="mt-3 grid grid-cols-1 lg:grid-cols-12 gap-3">
            <select id="fKategori" aria-label="Filter kategori barang" class="ai-input lg:col-span-3 text-slate-600">
              <option value="semua">Kategori: Semua Kategori</option>
              <option value="elektronik">Elektronik IT</option>
              <option value="alat-kerja">Alat Kerja &amp; Hardware</option>
              <option value="packaging">Packaging</option>
              <option value="k3">K3 &amp; Keselamatan</option>
              <option value="infrastruktur">Infrastruktur DC</option>
            </select>
            <select id="fLokasi" aria-label="Filter lokasi hub" class="ai-input lg:col-span-3 text-slate-600">
              <option value="cakung">Lokasi: Hub Cakung DC-01 (Utama)</option>
              <option value="surabaya">Hub Surabaya DC-02</option>
              <option value="semua">Semua Lokasi</option>
            </select>
            <select id="fUrgensi" aria-label="Filter urgensi dead stock" class="ai-input lg:col-span-3 text-slate-600">
              <option value="semua">Urgensi Dead Stock: &gt; 90 Hari</option>
              <option value="sehat">Sehat (&lt; 90 Hari)</option>
              <option value="aging">Aging (&gt; 90 Hari)</option>
            </select>
            <div class="lg:col-span-3 relative">
              <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
              <input id="anaSearch" type="search" aria-label="Cari SKU, nama barang, atau batch" class="ai-input pl-10" placeholder="Cari SKU, Nama Barang, Batch..." />
            </div>
          </div>
        </section>

        <!-- ===== Panel: Overview ===== -->
        <div data-tabpanel="laporan" data-panel-name="semua" role="tabpanel" aria-label="Overview laporan analitik">
          <section class="grid grid-cols-1 xl:grid-cols-5 gap-4">
            <!-- Chart card -->
            <div class="ai-card ai-card-hover ai-reveal p-5 xl:col-span-3" data-delay="150">
              <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                  <h2 class="text-[16px] font-extrabold text-slate-800">Tren Arus Barang Bulanan (Inbound vs Outbound)</h2>
                  <p class="mt-1 text-[12px] text-slate-500">Perbandingan volume unit barang masuk dan keluar per minggu dalam 8 minggu terakhir.</p>
                </div>
                <div class="flex items-center gap-4 text-[11.5px] font-semibold text-slate-600">
                  <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#a5b4fc]"></span>Inbound</span>
                  <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#2563eb]"></span>Outbound</span>
                </div>
              </div>
              <div class="mt-4 relative" style="height: 340px;">
                <canvas id="arusChart" role="img" aria-label="Grafik batang volume inbound dan outbound per minggu"></canvas>
                <div id="arusChartEmpty" class="hidden absolute inset-0 items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 px-6 text-center">
                  <p class="text-[12.5px] leading-relaxed text-slate-500">Grafik tidak dapat dimuat karena pustaka Chart.js tidak tersedia. Ringkasan angka tetap tampil pada kartu di bawah grafik.</p>
                </div>
              </div>
              <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3 rounded-xl bg-slate-50 border border-slate-100 p-4">
                <div>
                  <div class="text-[11px] font-semibold text-slate-500">Rata-rata Inbound:</div>
                  <div class="mt-0.5 text-[15px] font-extrabold text-slate-800">3.102 Qty / Minggu</div>
                </div>
                <div>
                  <div class="text-[11px] font-semibold text-slate-500">Rata-rata Outbound:</div>
                  <div class="mt-0.5 text-[15px] font-extrabold text-slate-800">3.570 Qty / Minggu</div>
                </div>
                <div>
                  <div class="text-[11px] font-semibold text-slate-500">Peak Dispatch Day:</div>
                  <div class="mt-0.5 text-[15px] font-extrabold text-blue-600">Selasa &amp; Kamis</div>
                </div>
              </div>
            </div>

            <!-- Komposisi valuasi -->
            <div class="ai-card ai-card-hover ai-reveal p-5 xl:col-span-2" data-delay="220">
              <h2 class="text-[16px] font-extrabold text-slate-800">Komposisi Valuasi Stok</h2>
              <p class="mt-1 text-[12px] text-slate-500">Distribusi nilai aset persediaan yang tersimpan di seluruh zona rak Hub.</p>

              <!-- Stacked bar -->
              <div class="mt-4 flex h-3.5 rounded-full overflow-hidden">
                <div style="width:42%; background:#2563eb;"></div>
                <div style="width:25%; background:#93c5fd;"></div>
                <div style="width:18%; background:#dbeafe;"></div>
                <div style="width:10%; background:#15803d;"></div>
                <div style="width:5%; background:#e2e8f0;"></div>
              </div>

              <div class="mt-5 space-y-4">
                <div class="flex items-start justify-between gap-3">
                  <div class="flex items-start gap-2.5">
                    <span class="w-3 h-3 rounded-full mt-1 flex-none" style="background:#2563eb"></span>
                    <div>
                      <div class="text-[13px] font-bold text-slate-700">Elektronik &amp; IT Hardware</div>
                      <div class="text-[11px] text-slate-500">482 SKU &bull; Zona A &amp; High-Security</div>
                    </div>
                  </div>
                  <div class="text-right flex-none">
                    <div class="text-[13.5px] font-extrabold text-slate-800">Rp 2.02 M</div>
                    <div class="text-[11px] font-bold text-blue-600">42%</div>
                  </div>
                </div>

                <div class="flex items-start justify-between gap-3">
                  <div class="flex items-start gap-2.5">
                    <span class="w-3 h-3 rounded-full mt-1 flex-none" style="background:#93c5fd"></span>
                    <div>
                      <div class="text-[13px] font-bold text-slate-700">Alat Kerja &amp; Mesin</div>
                      <div class="text-[11px] text-slate-500">310 SKU &bull; Zona B &amp; Mezzanine</div>
                    </div>
                  </div>
                  <div class="text-right flex-none">
                    <div class="text-[13.5px] font-extrabold text-slate-800">Rp 1.20 M</div>
                    <div class="text-[11px] font-bold text-blue-600">25%</div>
                  </div>
                </div>

                <div class="flex items-start justify-between gap-3">
                  <div class="flex items-start gap-2.5">
                    <span class="w-3 h-3 rounded-full mt-1 flex-none" style="background:#dbeafe"></span>
                    <div>
                      <div class="text-[13px] font-bold text-slate-700">Packaging &amp; Material</div>
                      <div class="text-[11px] text-slate-500">194 SKU &bull; Zona Pallet C-01</div>
                    </div>
                  </div>
                  <div class="text-right flex-none">
                    <div class="text-[13.5px] font-extrabold text-slate-800">Rp 867 Juta</div>
                    <div class="text-[11px] font-bold text-blue-600">18%</div>
                  </div>
                </div>

                <div class="flex items-start justify-between gap-3">
                  <div class="flex items-start gap-2.5">
                    <span class="w-3 h-3 rounded-full mt-1 flex-none" style="background:#15803d"></span>
                    <div>
                      <div class="text-[13px] font-bold text-slate-700">Perlengkapan K3 &amp; Uniform</div>
                      <div class="text-[11px] text-slate-500">142 SKU &bull; Racking D-02</div>
                    </div>
                  </div>
                  <div class="text-right flex-none">
                    <div class="text-[13.5px] font-extrabold text-slate-800">Rp 482 Juta</div>
                    <div class="text-[11px] font-bold text-blue-600">10%</div>
                  </div>
                </div>

                <div class="flex items-start justify-between gap-3">
                  <div class="flex items-start gap-2.5">
                    <span class="w-3 h-3 rounded-full mt-1 flex-none" style="background:#e2e8f0"></span>
                    <div>
                      <div class="text-[13px] font-bold text-slate-700">ATK &amp; Inventaris Kantor</div>
                      <div class="text-[11px] text-slate-500">112 SKU &bull; Ruang Kabinet E</div>
                    </div>
                  </div>
                  <div class="text-right flex-none">
                    <div class="text-[13.5px] font-extrabold text-slate-800">Rp 241 Juta</div>
                    <div class="text-[11px] font-bold text-blue-600">5%</div>
                  </div>
                </div>
              </div>

              <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-[10.5px] font-bold tracking-[0.06em] text-slate-400">TOTAL EVALUATED POOL</span>
                <span class="text-[12.5px] font-bold text-slate-500">100% <span class="text-blue-600">Sesuai SAP ERP</span></span>
              </div>
            </div>
          </section>
        </div>

        <!-- Panel tab lainnya -->
        <div data-tabpanel="laporan" data-panel-name="aging" role="tabpanel" style="display:none">
          <section class="ai-card ai-empty">
            <div class="ai-empty-icon"><i data-lucide="bar-chart-3" class="w-6 h-6"></i></div>
            <h3 class="text-[15px] font-bold text-slate-800">Perputaran &amp; Aging Stok</h3>
            <p class="max-w-md text-[12.5px] text-slate-500">Breakdown usia persediaan (Days on Hand) per kategori dan zona rak belum tersedia untuk periode ini.</p>
            <span class="ai-badge bg-amber-50 text-amber-700 mt-2">Belum tersedia</span>
            <button type="button" class="ai-btn ai-btn-secondary mt-3" data-tab-target="semua"><i data-lucide="arrow-left" class="w-4 h-4"></i>Kembali ke Overview</button>
          </section>
        </div>
        <div data-tabpanel="laporan" data-panel-name="throughput" role="tabpanel" style="display:none">
          <section class="ai-card ai-empty">
            <div class="ai-empty-icon"><i data-lucide="arrow-right-left" class="w-6 h-6"></i></div>
            <h3 class="text-[15px] font-bold text-slate-800">Throughput Inbound/Outbound</h3>
            <p class="max-w-md text-[12.5px] text-slate-500">Analisis throughput per jam dan per dock door tersedia pada laporan operasional mingguan.</p>
            <button type="button" class="ai-btn ai-btn-secondary mt-3" data-toast="Laporan operasional mingguan belum tersedia di modul ini" data-toast-type="info"><i data-lucide="external-link" class="w-4 h-4"></i>Buka Laporan Operasional Mingguan</button>
            <button type="button" class="mt-2 text-[12.5px] font-bold text-blue-600 hover:text-blue-700" data-tab-target="semua">Kembali ke Overview</button>
          </section>
        </div>
        <div data-tabpanel="laporan" data-panel-name="abc" role="tabpanel" style="display:none">
          <section class="ai-card ai-empty">
            <div class="ai-empty-icon"><i data-lucide="shapes" class="w-6 h-6"></i></div>
            <h3 class="text-[15px] font-bold text-slate-800">Klasifikasi ABC &amp; Fast Moving</h3>
            <p class="max-w-md text-[12.5px] text-slate-500">Pareto kontribusi valuasi per SKU (Kelas A/B/C) ditampilkan pada ringkasan kuarter. Rincian per SKU dapat dilihat pada tabel di bawah halaman ini.</p>
            <button type="button" class="ai-btn ai-btn-secondary mt-3" data-tab-target="semua"><i data-lucide="arrow-left" class="w-4 h-4"></i>Kembali ke Overview</button>
          </section>
        </div>
        <div data-tabpanel="laporan" data-panel-name="rak" role="tabpanel" style="display:none">
          <section class="ai-card ai-empty">
            <div class="ai-empty-icon"><i data-lucide="warehouse" class="w-6 h-6"></i></div>
            <h3 class="text-[15px] font-bold text-slate-800">Kapasitas Rak Gudang</h3>
            <p class="max-w-md text-[12.5px] text-slate-500">Utilisasi kapasitas zona rak A&ndash;E Hub Cakung DC-01 belum tersinkron dengan WMS.</p>
            <span class="ai-badge bg-amber-50 text-amber-700 mt-2">Sinkronisasi WMS tertunda</span>
            <button type="button" class="ai-btn ai-btn-secondary mt-3" data-tab-target="semua"><i data-lucide="arrow-left" class="w-4 h-4"></i>Kembali ke Overview</button>
          </section>
        </div>

        <!-- ===== Tabel SKU ABC ===== -->
        <section class="ai-card ai-reveal p-4 md:p-5" data-delay="200">
          <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
              <h2 class="text-[16px] font-extrabold text-slate-800">Analisis Performa SKU &amp; Klasifikasi ABC (Top Movers &amp; Aging)</h2>
              <p class="mt-1 text-[12px] text-slate-500">Peringkat velositas persediaan, Days on Hand (DOH), serta rekomendasi pengadaan stok otomatis.</p>
            </div>
            <div class="flex items-center gap-2">
              <button class="ai-btn ai-btn-secondary" data-toast="Panel Filter Lanjutan dibuka" data-toast-type="info"><i data-lucide="filter" class="w-4 h-4"></i>Filter Lanjutan</button>
              <button class="ai-btn ai-btn-secondary" data-toast="Pengaturan kolom tabel dibuka" data-toast-type="info"><i data-lucide="sliders-horizontal" class="w-4 h-4"></i>Sesuaikan Kolom</button>
            </div>
          </div>

          <div class="mt-4 overflow-x-auto">
            <table class="w-full ai-table min-w-[1050px]">
              <thead>
                <tr>
                  <th scope="col">Kode SKU &amp; Nama Barang</th>
                  <th scope="col">Kategori</th>
                  <th scope="col">Stok On-Hand</th>
                  <th scope="col">Avg Keluar/Bln</th>
                  <th scope="col">DOH (Days on Hand)</th>
                  <th scope="col">Klasifikasi ABC</th>
                  <th scope="col">Status Rekomendasi</th>
                  <th scope="col" class="text-right">Aksi</th>
                </tr>
              </thead>
              <tbody id="skuBody">
                <tr data-cat="elektronik" data-lok="cakung" data-urgensi="sehat"
                    data-text="macbook pro 14 m1 pro sku-lap-0921 sn-tracked elektronik it 48 unit kelas a">
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-none"><i data-lucide="laptop" class="w-[18px] h-[18px] text-blue-600"></i></div>
                      <div>
                        <div class="font-bold text-slate-700">MacBook Pro 14" M1 Pro</div>
                        <div class="text-[11px] text-slate-500">SKU-LAP-0921 &bull; SN-Tracked</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600">Elektronik IT</span></td>
                  <td class="font-bold text-slate-700">48 Unit</td>
                  <td class="text-slate-600">35 Unit/bln</td>
                  <td class="font-semibold text-slate-700">41 Hari</td>
                  <td><span class="ai-badge bg-blue-50 text-blue-700">Kelas A (High Value)</span></td>
                  <td><span class="text-[12px] font-bold text-emerald-600 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Reorder Point Terjaga (Aman)</span></td>
                  <td class="text-right"><button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Menu aksi SKU-LAP-0921 dibuka" data-toast-type="info" title="Menu" aria-label="Buka menu aksi barang"><i data-lucide="more-horizontal" class="w-4 h-4"></i></button></td>
                </tr>

                <tr data-cat="alat-kerja" data-lok="cakung" data-urgensi="sehat"
                    data-text="zebra tc21 barcode scanner sku-scn-0055 batch b24 alat kerja hardware 85 unit kelas a">
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-none"><i data-lucide="scan-line" class="w-[18px] h-[18px] text-blue-600"></i></div>
                      <div>
                        <div class="font-bold text-slate-700">Zebra TC21 Barcode Scanner</div>
                        <div class="text-[11px] text-slate-500">SKU-SCN-0055 &bull; Batch B24</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600">Alat Kerja &amp; Hardware</span></td>
                  <td class="font-bold text-slate-700">85 Unit</td>
                  <td class="text-slate-600">62 Unit/bln</td>
                  <td class="font-semibold text-slate-700">41 Hari</td>
                  <td><span class="ai-badge bg-blue-50 text-blue-700">Kelas A (High Value)</span></td>
                  <td><span class="text-[12px] font-bold text-blue-600 flex items-center gap-1.5"><i data-lucide="trending-up" class="w-3.5 h-3.5"></i>Permintaan Naik +18%</span></td>
                  <td class="text-right"><button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Menu aksi SKU-SCN-0055 dibuka" data-toast-type="info" title="Menu" aria-label="Buka menu aksi barang"><i data-lucide="more-horizontal" class="w-4 h-4"></i></button></td>
                </tr>

                <tr data-cat="packaging" data-lok="cakung" data-urgensi="sehat"
                    data-text="bubble wrap roll 50m heavy sku-pkg-0112 pallet c-01 packaging 320 roll kelas b restock">
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-none"><i data-lucide="package" class="w-[18px] h-[18px] text-blue-600"></i></div>
                      <div>
                        <div class="font-bold text-slate-700">Bubble Wrap Roll 50m Heavy</div>
                        <div class="text-[11px] text-slate-500">SKU-PKG-0112 &bull; Pallet C-01</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600">Packaging</span></td>
                  <td class="font-bold text-slate-700">320 Roll</td>
                  <td class="text-slate-600">410 Roll/bln</td>
                  <td class="font-bold text-red-600">23 Hari</td>
                  <td><span class="ai-badge bg-indigo-50 text-indigo-700">Kelas B (High Velocity)</span></td>
                  <td><span class="text-[12px] font-bold text-red-600 flex items-center gap-1.5"><i data-lucide="alert-triangle" class="w-3.5 h-3.5"></i>Perlu Restock &lt; 5 Hari</span></td>
                  <td class="text-right"><button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Menu aksi SKU-PKG-0112 dibuka" data-toast-type="info" title="Menu" aria-label="Buka menu aksi barang"><i data-lucide="more-horizontal" class="w-4 h-4"></i></button></td>
                </tr>

                <tr data-cat="k3" data-lok="cakung" data-urgensi="aging"
                    data-text="sarung tangan antistatik esd sku-hse-4421 rack d-02 k3 keselamatan 210 box kelas c slow moving">
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-none"><i data-lucide="hand" class="w-[18px] h-[18px] text-blue-600"></i></div>
                      <div>
                        <div class="font-bold text-slate-700">Sarung Tangan Antistatik ESD</div>
                        <div class="text-[11px] text-slate-500">SKU-HSE-4421 &bull; Rack D-02</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600">K3 &amp; Keselamatan</span></td>
                  <td class="font-bold text-slate-700">210 Box</td>
                  <td class="text-slate-600">45 Box/bln</td>
                  <td class="font-semibold text-slate-700">140 Hari</td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600">Kelas C (Slow Moving)</span></td>
                  <td><span class="text-[12px] font-bold text-slate-500 flex items-center gap-1.5"><i data-lucide="search" class="w-3.5 h-3.5"></i>Review Pembelian / Slow</span></td>
                  <td class="text-right"><button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Menu aksi SKU-HSE-4421 dibuka" data-toast-type="info" title="Menu" aria-label="Buka menu aksi barang"><i data-lucide="more-horizontal" class="w-4 h-4"></i></button></td>
                </tr>

                <tr data-cat="infrastruktur" data-lok="cakung" data-urgensi="aging"
                    data-text="server rack mount shelf 2u sku-srv-8802 zona gudang cadangan infrastruktur dc 12 unit dead stock">
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-none"><i data-lucide="server" class="w-[18px] h-[18px] text-blue-600"></i></div>
                      <div>
                        <div class="font-bold text-slate-700">Server Rack Mount Shelf 2U</div>
                        <div class="text-[11px] text-slate-500">SKU-SRV-8802 &bull; Zona Gudang Cadangan</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600">Infrastruktur DC</span></td>
                  <td class="font-bold text-slate-700">12 Unit</td>
                  <td class="text-slate-600">1 Unit/bln</td>
                  <td class="font-bold text-red-600">360 Hari</td>
                  <td><span class="ai-badge bg-red-50 text-red-600">Dead Stock (&gt;180 Hari)</span></td>
                  <td><span class="text-[12px] font-bold text-red-600 flex items-center gap-1.5"><i data-lucide="archive-x" class="w-3.5 h-3.5"></i>Relokasi / Write-down</span></td>
                  <td class="text-right"><button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Menu aksi SKU-SRV-8802 dibuka" data-toast-type="info" title="Menu" aria-label="Buka menu aksi barang"><i data-lucide="more-horizontal" class="w-4 h-4"></i></button></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div id="skuEmpty" class="hidden py-10 text-center">
            <i data-lucide="search-x" class="w-8 h-8 text-slate-300 mx-auto"></i>
            <div class="mt-2 text-[13px] font-semibold text-slate-500">Tidak ada SKU yang cocok dengan filter.</div>
          </div>

          <!-- Pagination -->
          <div class="mt-4 flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-slate-100">
            <div class="text-[12px] text-slate-500 font-medium"><span id="skuCountInfo">Menampilkan 1 - 5 dari 1.240 SKU Teranalisis</span> &bull; Halaman 1 dari 248</div>
            <div class="flex items-center gap-1.5">
              <button type="button" aria-label="Halaman sebelumnya" class="w-9 h-9 rounded-lg text-slate-400 hover:bg-slate-100 flex items-center justify-center" disabled><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
              <button class="w-9 h-9 rounded-lg bg-blue-600 text-white text-[12.5px] font-bold shadow-md shadow-blue-600/30">1</button>
              <button class="w-9 h-9 rounded-lg text-[12.5px] font-semibold text-slate-600 hover:bg-slate-100" data-toast="Halaman 2 dimuat" data-toast-type="info">2</button>
              <button class="w-9 h-9 rounded-lg text-[12.5px] font-semibold text-slate-600 hover:bg-slate-100" data-toast="Halaman 3 dimuat" data-toast-type="info">3</button>
              <span class="text-slate-400 px-1">...</span>
              <button class="w-9 h-9 rounded-lg text-[12.5px] font-semibold text-slate-600 hover:bg-slate-100" data-toast="Halaman 248 dimuat" data-toast-type="info">248</button>
              <button type="button" aria-label="Halaman berikutnya" class="w-9 h-9 rounded-lg text-slate-600 hover:bg-slate-100 flex items-center justify-center" data-toast="Halaman 2 dimuat" data-toast-type="info"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
            </div>
          </div>
        </section>

        <!-- ===== Info cards ===== -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="0">
            <h3 class="text-[14.5px] font-bold text-red-600 flex items-center gap-2"><i data-lucide="alert-triangle" class="w-4 h-4"></i>Peringatan Dead Stock &amp; Aging</h3>
            <p class="mt-2.5 text-[12.5px] text-slate-500 leading-relaxed">Terdapat 8 SKU dengan usia simpan &gt; 180 hari senilai Rp 84.5 Juta tanpa pergerakan mutasi dalam 60 hari terakhir.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Daftar SKU Dead Stock dimuat" data-toast-type="info">Lihat Daftar SKU Dead Stock <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></button>
          </div>
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="80">
            <h3 class="text-[14.5px] font-bold text-blue-600 flex items-center gap-2"><i data-lucide="brain-circuit" class="w-4 h-4"></i>Optimasi ROP &amp; Safety Stock</h3>
            <p class="mt-2.5 text-[12.5px] text-slate-500 leading-relaxed">Algoritma prediktif mendeteksi lonjakan outbound pada 3 SKU kemasan untuk periode menjelang awal bulan operasional Hub.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Jadwal Pembelian Ulang dibuka" data-toast-type="info">Buka Jadwal Pembelian Ulang <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></button>
          </div>
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="160">
            <h3 class="text-[14.5px] font-bold text-emerald-700 flex items-center gap-2"><i data-lucide="landmark" class="w-4 h-4"></i>Integrasi Audit &amp; Finansial</h3>
            <p class="mt-2.5 text-[12.5px] text-slate-500 leading-relaxed">Laporan analitik telah diselaraskan dengan standar akuntansi persediaan FIFO &amp; Moving Average untuk laporan audit Q1 2025.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Rekap Laporan Keuangan (XLSX) diunduh">Unduh Rekap Laporan Keuangan (XLSX) <i data-lucide="download" class="w-3.5 h-3.5"></i></button>
          </div>
        </section>
        @endif

    </main>
</div>

<script>
    (function () {
      /* ---------- Chart: Tren Arus Barang ---------- */
      var canvas = document.getElementById("arusChart");
      var chartFallback = document.getElementById("arusChartEmpty");
      if (canvas && !window.Chart && chartFallback) {
        chartFallback.classList.remove("hidden");
        chartFallback.classList.add("flex");
      }
      if (canvas && window.Chart) {
        var annotation = {
          id: "peakAnnotation",
          afterDatasetsDraw: function (chart) {
            var meta = chart.getDatasetMeta(1); // outbound
            var point = meta && meta.data[5];   // M-6
            if (!point) return;
            var y = point.y;
            var ctx = chart.ctx;
            var area = chart.chartArea;
            ctx.save();
            ctx.strokeStyle = "#1e3a8a";
            ctx.setLineDash([5, 4]);
            ctx.lineWidth = 1.4;
            ctx.beginPath();
            ctx.moveTo(area.left, y);
            ctx.lineTo(point.x, y);
            ctx.stroke();
            ctx.setLineDash([]);
            ctx.fillStyle = "#1e3a8a";
            ctx.font = "700 11px Inter, sans-serif";
            ctx.textAlign = "center";
            ctx.fillText("4.180 Qty", point.x, y - 8);
            // marker dot
            ctx.fillStyle = "#1e3a8a";
            ctx.beginPath();
            ctx.arc(point.x, y, 3.5, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
          }
        };

        new Chart(canvas, {
          type: "bar",
          data: {
            labels: ["M-1", "M-2", "M-3", "M-4", "M-5", "M-6", "M-7", "M-8 (Kini)"],
            datasets: [
              {
                label: "Inbound",
                data: [3250, 3050, 3620, 3080, 3860, 3420, 3560, 3380],
                backgroundColor: "#a5b4fc",
                borderRadius: 4,
                barPercentage: 0.55,
                categoryPercentage: 0.72
              },
              {
                label: "Outbound",
                data: [3720, 3480, 3950, 3520, 4050, 4180, 3880, 3960],
                backgroundColor: "#2563eb",
                borderRadius: 4,
                barPercentage: 0.55,
                categoryPercentage: 0.72
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false },
              tooltip: {
                backgroundColor: "#0f172a",
                padding: 10,
                cornerRadius: 8,
                callbacks: {
                  label: function (c) {
                    return " " + c.dataset.label + ": " + c.parsed.y.toLocaleString("id-ID") + " Qty";
                  }
                }
              }
            },
            scales: {
              x: { grid: { display: false }, ticks: { color: "#64748b", font: { size: 11, weight: "600" } } },
              y: {
                beginAtZero: true,
                max: 4600,
                grid: { color: "#eef2f7" },
                ticks: {
                  color: "#94a3b8",
                  font: { size: 11 },
                  stepSize: 1500,
                  callback: function (v) { return v === 0 ? "0" : (v / 1000).toFixed(1).replace(".", ".") + "k"; }
                }
              }
            }
          },
          plugins: [annotation]
        });
      }

      /* ---------- Filter tabel SKU ---------- */
      var rows = Array.prototype.slice.call(document.querySelectorAll("#skuBody tr"));
      var search = document.getElementById("anaSearch");
      var fKategori = document.getElementById("fKategori");
      var fLokasi = document.getElementById("fLokasi");
      var fUrgensi = document.getElementById("fUrgensi");
      var empty = document.getElementById("skuEmpty");

      var countInfo = document.getElementById("skuCountInfo");
      var totalSku = 1240;
      var resetBtn = document.getElementById("resetFilters");
      var initial = { kategori: fKategori.value, lokasi: fLokasi.value, urgensi: fUrgensi.value };

      function applyFilter() {
        var q = (search.value || "").trim().toLowerCase();
        var shown = 0;
        rows.forEach(function (r) {
          var ok = true;
          if (fKategori.value !== "semua" && r.getAttribute("data-cat") !== fKategori.value) ok = false;
          if (ok && fLokasi.value !== "semua" && r.getAttribute("data-lok") !== fLokasi.value) ok = false;
          if (ok && fUrgensi.value !== "semua" && r.getAttribute("data-urgensi") !== fUrgensi.value) ok = false;
          if (ok && q && (r.getAttribute("data-text") + " " + r.textContent.toLowerCase()).indexOf(q) === -1) ok = false;
          r.style.display = ok ? "" : "none";
          if (ok) shown++;
        });
        empty.classList.toggle("hidden", shown > 0);
        if (countInfo) {
          var difilter = q !== "" ||
            fKategori.value !== initial.kategori ||
            fLokasi.value !== initial.lokasi ||
            fUrgensi.value !== initial.urgensi;
          if (shown === 0) {
            countInfo.textContent = "Tidak ada SKU yang cocok dari " + totalSku.toLocaleString("id-ID") + " SKU Teranalisis";
          } else if (difilter) {
            countInfo.textContent = "Menampilkan " + shown + " dari " + totalSku.toLocaleString("id-ID") + " SKU Teranalisis (difilter)";
          } else {
            countInfo.textContent = "Menampilkan " + shown + " baris dari " + totalSku.toLocaleString("id-ID") + " SKU Teranalisis";
          }
        }
      }

      search.addEventListener("input", applyFilter);
      [fKategori, fLokasi, fUrgensi].forEach(function (s) { s.addEventListener("change", applyFilter); });

      /* Reset semua filter ke kondisi awal halaman */
      if (resetBtn) {
        resetBtn.addEventListener("click", function () {
          search.value = "";
          fKategori.value = initial.kategori;
          fLokasi.value = initial.lokasi;
          fUrgensi.value = initial.urgensi;
          applyFilter();
          if (window.aiToast) window.aiToast("Filter dikembalikan ke kondisi awal", "info");
        });
      }

      applyFilter();
      window.aiRefresh();
    })();
</script>
</body>
</html>
