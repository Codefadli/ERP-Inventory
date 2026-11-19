<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan & Riwayat Transaksi | Astro Inventory</title>

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

    /* .ai-empty memakai display:flex; pastikan kelas .hidden tetap menang */
    .ai-empty.hidden {
        display: none !important;
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
          <div data-breadcrumb='[{"label":"MANAJEMEN SISTEM"},{"label":"LAPORAN & RIWAYAT TRANSAKSI"}]'></div>
        </div>

        <!-- ===== Header card ===== -->
        <section class="ai-card ai-card-hover ai-reveal p-6">
          <div class="flex flex-col xl:flex-row xl:items-start gap-5 justify-between">
            <div class="max-w-xl">
              <h1 class="text-[24px] font-extrabold text-slate-800 leading-tight">Laporan &amp; Riwayat Transaksi</h1>
              <p class="mt-2 text-[13px] text-slate-500 leading-relaxed">Arsip komprehensif seluruh mutasi masuk (inbound), keluar (outbound), penyesuaian stok opname, dan surat jalan operasional Hub Cakung DC-01.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5 flex-none">
              <button class="ai-btn ai-btn-secondary" data-toast="Periode: 30 Hari Terakhir (1 Feb - 2 Mar 2025)" data-toast-type="info">
                <i data-lucide="calendar" class="w-4 h-4"></i>30 Hari Terakhir (1 Feb - 2 Mar 2025)<i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
              </button>
              <button class="ai-btn ai-btn-secondary" data-toast="Panel Filter Lanjutan dibuka" data-toast-type="info">
                <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>Filter Lanjutan
              </button>
              <button class="ai-btn ai-btn-secondary" data-toast="Export Excel/CSV dimulai">
                <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>Export Excel / CSV
              </button>
              <button class="ai-btn ai-btn-primary" data-toast="Form Buat Laporan Khusus / Audit dibuka" data-toast-type="info">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>Buat Laporan Khusus / Audit
              </button>
            </div>
          </div>
        </section>

        <!-- ===== Statistik ===== -->
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="0">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i></div>
              <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="trending-up" class="w-3 h-3"></i>+12.4% vs Bulan Lalu</span>
            </div>
            <div class="mt-4 text-[30px] font-extrabold text-slate-800 leading-none"><span data-count="2418">0</span> Dokumen</div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Total Transaksi Dicatat</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] font-semibold text-emerald-600"><i data-lucide="badge-check" class="w-3.5 h-3.5"></i>Arsip digital tersertifikasi valid</div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="80">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="wallet" class="w-5 h-5 text-blue-600"></i></div>
              <span class="ai-badge bg-slate-100 text-slate-600"><i data-lucide="link-2" class="w-3 h-3"></i>100% Rekonsiliasi SAP ERP</span>
            </div>
            <div class="mt-4 text-[30px] font-extrabold text-slate-800 leading-none">Rp <span data-count="3.86" data-decimals="2">0</span> Milyar</div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Akumulasi Valuasi Mutasi</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] text-slate-500"><i data-lucide="scale" class="w-3.5 h-3.5"></i>Inbound &amp; outbound seimbang di buku besar</div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="160">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="arrow-down-to-line" class="w-5 h-5 text-blue-600"></i></div>
              <span class="ai-badge bg-blue-50 text-blue-700">47.1% Total Trafik</span>
            </div>
            <div class="mt-4 text-[30px] font-extrabold text-slate-800 leading-none"><span data-count="1140">0</span> Dokumen</div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Transaksi Inbound Selesai</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] font-semibold text-emerald-600"><i data-lucide="badge-check" class="w-3.5 h-3.5"></i>Surat Jalan &amp; PO Supplier Lolos QC 100%</div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="240">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="arrow-up-from-line" class="w-5 h-5 text-blue-600"></i></div>
              <span class="ai-badge bg-blue-50 text-blue-700">52.9% Total Trafik</span>
            </div>
            <div class="mt-4 text-[30px] font-extrabold text-slate-800 leading-none"><span data-count="1278">0</span> Dokumen</div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Transaksi Outbound Selesai</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] text-slate-500"><i data-lucide="truck" class="w-3.5 h-3.5"></i>Surat Jalan Distribusi &amp; Bukti Serah Terima</div>
          </div>
        </section>

        <!-- ===== Pill filter ===== -->
        <section class="ai-card ai-reveal p-4" data-delay="100">
          <div class="flex flex-wrap items-center gap-2">
            <div data-tabs="riwayat" class="flex min-w-0 flex-1 gap-2 overflow-x-auto pb-1" role="tablist" aria-label="Kategori riwayat dokumen">
              <button type="button" role="tab" aria-selected="true" class="ai-pill ai-pill-active" data-tab="semua">Semua Riwayat (2.418)</button>
              <button type="button" role="tab" aria-selected="false" class="ai-pill" data-tab="masuk">Barang Masuk / Inbound (1.140)</button>
              <button type="button" role="tab" aria-selected="false" class="ai-pill" data-tab="keluar">Barang Keluar / Outbound (1.278)</button>
              <button type="button" role="tab" aria-selected="false" class="ai-pill" data-tab="adj">Penyesuaian Opname (48)</button>
              <button type="button" role="tab" aria-selected="false" class="ai-pill" data-tab="mutasi">Mutasi Antar Hub / Rak (112)</button>
            </div>
            <button type="button" id="resetFilters" class="ai-btn ai-btn-soft flex-none" aria-label="Reset semua filter"><i data-lucide="rotate-ccw" class="w-4 h-4"></i>Reset</button>
          </div>
          <div class="mt-3 grid grid-cols-1 lg:grid-cols-12 gap-3">
            <div class="lg:col-span-4 relative">
              <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
              <input id="riwSearch" type="search" aria-label="Cari nomor dokumen, surat jalan, SKU, atau PIC" class="ai-input pl-10" placeholder="Cari No. Dokumen, No. Surat Jalan, SKU, PIC..." />
            </div>
            <select id="fTipe" aria-label="Filter tipe dokumen" class="ai-input lg:col-span-2 text-slate-600">
              <option value="semua">Semua Tipe Dokumen</option>
              <option value="keluar">Outbound</option>
              <option value="masuk">Inbound</option>
              <option value="adj">Stock Opname Adj</option>
              <option value="mutasi">Mutasi</option>
            </select>
            <select id="fDivisi" aria-label="Filter divisi atau mitra" class="ai-input lg:col-span-2 text-slate-600">
              <option value="semua">Semua Divisi / Mitra</option>
              <option value="it">Divisi IT &amp; Digital Infra</option>
              <option value="mitra">Supplier / Mitra Eksternal</option>
              <option value="audit">Tim Internal Audit</option>
              <option value="maintenance">Divisi Maintenance</option>
              <option value="internal">Internal Gudang</option>
            </select>
            <select id="fStatus" aria-label="Filter status dokumen" class="ai-input lg:col-span-2 text-slate-600">
              <option value="semua">Semua Status</option>
              <option value="archived">Selesai (Archived)</option>
              <option value="qc">Tervalidasi QC</option>
              <option value="disetujui">Disetujui Kepala Hub</option>
            </select>
            <div class="lg:col-span-2">
              <button type="button" id="btnUnduh" class="ai-btn ai-btn-secondary w-full"><i data-lucide="download" class="w-4 h-4"></i><span id="unduhLabel" aria-live="polite">Unduh Terpilih</span></button>
            </div>
          </div>
        </section>

        <!-- ===== Tabel riwayat ===== -->
        <section class="ai-card ai-reveal p-4 md:p-5" data-delay="150">
          <div class="overflow-x-auto">
            <table class="w-full ai-table min-w-[1180px]">
              <thead>
                <tr>
                  <th scope="col" class="w-10"><input type="checkbox" id="checkAll" aria-label="Pilih semua dokumen yang tampil" class="w-4 h-4 accent-blue-600 cursor-pointer" /></th>
                  <th scope="col">No. Dokumen<br />&amp; Waktu</th>
                  <th scope="col">Jenis Transaksi</th>
                  <th scope="col">Ref Surat Jalan / PO</th>
                  <th scope="col">Divisi / Pihak Terkait</th>
                  <th scope="col">Ringkasan Barang &amp; QTY</th>
                  <th scope="col" class="text-right">Valuasi (IDR)</th>
                  <th scope="col">PIC / Otorisator</th>
                  <th scope="col">Status Dokumen</th>
                  <th scope="col" class="text-right">Aksi</th>
                </tr>
              </thead>
              <tbody id="riwBody">
                <!-- Row 1 -->
                <tr data-cat="keluar" data-div="it" data-status="archived"
                    data-text="doc-out-2025-0941 02 mar 2025 14:20 wib outbound hub sj-out-2025-0402 divisi it digital infra macbook pro 14 m1 pro 105.000.000 adrian pratama">
                  <td><input type="checkbox" class="rowCheck w-4 h-4 accent-blue-600 cursor-pointer" /></td>
                  <td>
                    <div class="font-bold text-blue-600">DOC-OUT-2025-0941</div>
                    <div class="text-[11px] text-slate-500 mt-1">02 Mar 2025, 14:20 WIB</div>
                  </td>
                  <td><span class="ai-badge bg-indigo-50 text-indigo-700"><i data-lucide="send" class="w-3 h-3"></i>Outbound Hub</span></td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600 font-mono">SJ-OUT-2025-0402</span></td>
                  <td>
                    <div class="font-bold text-slate-700">Divisi IT &amp; Digital Infra</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Departemen Head Office Lt. 4</div>
                  </td>
                  <td class="max-w-[190px]">
                    <div class="font-bold text-slate-700 leading-snug">5 Unit MacBook Pro 14" M1 Pro</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">SKU: LAP-APL-MBP14 &bull; Bin RAK-A3</div>
                  </td>
                  <td class="text-right font-extrabold text-slate-800 whitespace-nowrap">Rp 105.000.000</td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-8 h-8 rounded-full bg-blue-600 text-white text-[10px] font-bold flex items-center justify-center flex-none">AP</div>
                      <div>
                        <div class="font-bold text-slate-700 text-[12.5px]">Adrian Pratama</div>
                        <div class="text-[10.5px] text-slate-500">Supervisor IT</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="ai-badge bg-emerald-400/90 text-emerald-950"><i data-lucide="archive" class="w-3 h-3"></i>Selesai (Archived)</span></td>
                  <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Melihat dokumen DOC-OUT-2025-0941" data-toast-type="info" title="Lihat" aria-label="Lihat dokumen"><i data-lucide="eye" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Mencetak dokumen DOC-OUT-2025-0941" data-toast-type="info" title="Cetak" aria-label="Cetak dokumen"><i data-lucide="printer" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Dokumen DOC-OUT-2025-0941 diunduh" title="Unduh" aria-label="Unduh dokumen"><i data-lucide="download" class="w-4 h-4"></i></button>
                    </div>
                  </td>
                </tr>

                <!-- Row 2 -->
                <tr data-cat="masuk" data-div="mitra" data-status="qc"
                    data-text="doc-in-2025-0892 02 mar 2025 11:05 wib inbound supplier sj-sup-88291 pt metrodata electronics zebra tc21 28.000.000 dedi kurniawan">
                  <td><input type="checkbox" class="rowCheck w-4 h-4 accent-blue-600 cursor-pointer" /></td>
                  <td>
                    <div class="font-bold text-blue-600">DOC-IN-2025-0892</div>
                    <div class="text-[11px] text-slate-500 mt-1">02 Mar 2025, 11:05 WIB</div>
                  </td>
                  <td><span class="ai-badge bg-sky-50 text-sky-700"><i data-lucide="corner-down-left" class="w-3 h-3"></i>Inbound Supplier</span></td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600 font-mono">SJ-SUP-88291</span></td>
                  <td>
                    <div class="font-bold text-slate-700">PT Metrodata Electronics</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Vendor Resmi Perangkat Auto-ID</div>
                  </td>
                  <td class="max-w-[190px]">
                    <div class="font-bold text-slate-700 leading-snug">20 Unit Zebra TC21 Barcode Scanner</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">SKU: SCN-ZBR-TC21 &bull; Bin RAK-B1</div>
                  </td>
                  <td class="text-right font-extrabold text-slate-800 whitespace-nowrap">Rp 28.000.000</td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-8 h-8 rounded-full bg-slate-500 text-white text-[10px] font-bold flex items-center justify-center flex-none">DK</div>
                      <div>
                        <div class="font-bold text-slate-700 text-[12.5px]">Dedi Kurniawan</div>
                        <div class="text-[10.5px] text-slate-500">Lead Inbound Staf</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="ai-badge bg-emerald-400/90 text-emerald-950"><i data-lucide="clipboard-check" class="w-3 h-3"></i>Tervalidasi QC</span></td>
                  <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Melihat dokumen DOC-IN-2025-0892" data-toast-type="info" title="Lihat" aria-label="Lihat dokumen"><i data-lucide="eye" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Mencetak dokumen DOC-IN-2025-0892" data-toast-type="info" title="Cetak" aria-label="Cetak dokumen"><i data-lucide="printer" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Dokumen DOC-IN-2025-0892 diunduh" title="Unduh" aria-label="Unduh dokumen"><i data-lucide="download" class="w-4 h-4"></i></button>
                    </div>
                  </td>
                </tr>

                <!-- Row 3 -->
                <tr data-cat="adj" data-div="audit" data-status="disetujui"
                    data-text="doc-adj-2025-0104 01 mar 2025 17:45 wib stock opname adj baso-q1-2025 tim internal audit koreksi -2 unit macbook discrepancy 42.000.000 maya anggraini">
                  <td><input type="checkbox" class="rowCheck w-4 h-4 accent-blue-600 cursor-pointer" /></td>
                  <td>
                    <div class="font-bold text-blue-600">DOC-ADJ-2025-0104</div>
                    <div class="text-[11px] text-slate-500 mt-1">01 Mar 2025, 17:45 WIB</div>
                  </td>
                  <td><span class="ai-badge bg-red-50 text-red-600"><i data-lucide="clipboard-list" class="w-3 h-3"></i>Stock Opname Adj</span></td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600 font-mono">BASO-Q1-2025</span></td>
                  <td>
                    <div class="font-bold text-slate-700">Tim Internal Audit</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Berita Acara Stock Opname</div>
                  </td>
                  <td class="max-w-[190px]">
                    <div class="font-bold text-red-600 leading-snug">Koreksi -2 Unit MacBook Pro (Discrepancy)</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">SKU: LAP-APL-MBP14 &bull; Bin RAK-A3</div>
                  </td>
                  <td class="text-right font-extrabold text-red-600 whitespace-nowrap">-Rp 42.000.000</td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-8 h-8 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center flex-none">MA</div>
                      <div>
                        <div class="font-bold text-slate-700 text-[12.5px]">Maya Anggraini</div>
                        <div class="text-[10.5px] text-slate-500">Senior Auditor</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="ai-badge bg-blue-50 text-blue-700"><i data-lucide="user-check" class="w-3 h-3"></i>Disetujui Kepala Hub</span></td>
                  <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Melihat dokumen DOC-ADJ-2025-0104" data-toast-type="info" title="Lihat" aria-label="Lihat dokumen"><i data-lucide="eye" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Mencetak dokumen DOC-ADJ-2025-0104" data-toast-type="info" title="Cetak" aria-label="Cetak dokumen"><i data-lucide="printer" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Dokumen DOC-ADJ-2025-0104 diunduh" title="Unduh" aria-label="Unduh dokumen"><i data-lucide="download" class="w-4 h-4"></i></button>
                    </div>
                  </td>
                </tr>

                <!-- Row 4 -->
                <tr data-cat="keluar" data-div="maintenance" data-status="archived"
                    data-text="doc-out-2025-0938 01 mar 2025 09:30 wib outbound hub sj-out-2025-0399 divisi maintenance fasilitas bubble wrap packing tape 4.500.000 hendra kusuma">
                  <td><input type="checkbox" class="rowCheck w-4 h-4 accent-blue-600 cursor-pointer" /></td>
                  <td>
                    <div class="font-bold text-blue-600">DOC-OUT-2025-0938</div>
                    <div class="text-[11px] text-slate-500 mt-1">01 Mar 2025, 09:30 WIB</div>
                  </td>
                  <td><span class="ai-badge bg-indigo-50 text-indigo-700"><i data-lucide="send" class="w-3 h-3"></i>Outbound Hub</span></td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600 font-mono">SJ-OUT-2025-0399</span></td>
                  <td>
                    <div class="font-bold text-slate-700">Divisi Maintenance &amp; Fasilitas</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Operasional Gudang Logistik</div>
                  </td>
                  <td class="max-w-[190px]">
                    <div class="font-bold text-slate-700 leading-snug">10 Roll Bubble Wrap &amp; Packing Tape</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">SKU: SUP-BW-50M &bull; Bin RAK-D1</div>
                  </td>
                  <td class="text-right font-extrabold text-slate-800 whitespace-nowrap">Rp 4.500.000</td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-8 h-8 rounded-full bg-sky-600 text-white text-[10px] font-bold flex items-center justify-center flex-none">HK</div>
                      <div>
                        <div class="font-bold text-slate-700 text-[12.5px]">Hendra Kusuma</div>
                        <div class="text-[10.5px] text-slate-500">Staf Logistik</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="ai-badge bg-emerald-400/90 text-emerald-950"><i data-lucide="archive" class="w-3 h-3"></i>Selesai (Archived)</span></td>
                  <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Melihat dokumen DOC-OUT-2025-0938" data-toast-type="info" title="Lihat" aria-label="Lihat dokumen"><i data-lucide="eye" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Mencetak dokumen DOC-OUT-2025-0938" data-toast-type="info" title="Cetak" aria-label="Cetak dokumen"><i data-lucide="printer" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Dokumen DOC-OUT-2025-0938 diunduh" title="Unduh" aria-label="Unduh dokumen"><i data-lucide="download" class="w-4 h-4"></i></button>
                    </div>
                  </td>
                </tr>

                <!-- Row 5 -->
                <tr data-cat="mutasi" data-div="internal" data-status="archived"
                    data-text="doc-trf-2025-0215 28 feb 2025 16:10 wib mutasi antar rak trf-rk-0012 gudang cadangan hub utama perlengkapan k3 sarung tangan 6.200.000 ir. bambang sugiarto">
                  <td><input type="checkbox" class="rowCheck w-4 h-4 accent-blue-600 cursor-pointer" /></td>
                  <td>
                    <div class="font-bold text-blue-600">DOC-TRF-2025-0215</div>
                    <div class="text-[11px] text-slate-500 mt-1">28 Feb 2025, 16:10 WIB</div>
                  </td>
                  <td><span class="ai-badge bg-blue-50 text-blue-700"><i data-lucide="arrow-right-left" class="w-3 h-3"></i>Mutasi Antar Rak</span></td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600 font-mono">TRF-RK-0012</span></td>
                  <td>
                    <div class="font-bold text-slate-700">Gudang Cadangan &rarr; Hub Utama</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Internal Bin Relocation</div>
                  </td>
                  <td class="max-w-[190px]">
                    <div class="font-bold text-slate-700 leading-snug">15 Box Perlengkapan K3 &amp; Sarung Tangan</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">SKU: HSE-GLV-09 &bull; Dari BIN-C02 ke BIN-A05</div>
                  </td>
                  <td class="text-right font-extrabold text-slate-800 whitespace-nowrap">Rp 6.200.000</td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-8 h-8 rounded-full bg-emerald-700 text-white text-[10px] font-bold flex items-center justify-center flex-none">BS</div>
                      <div>
                        <div class="font-bold text-slate-700 text-[12.5px]">Ir. Bambang Sugiarto</div>
                        <div class="text-[10.5px] text-slate-500">Kepala Gudang Cakung</div>
                      </div>
                    </div>
                  </td>
                  <td><span class="ai-badge bg-emerald-400/90 text-emerald-950"><i data-lucide="archive" class="w-3 h-3"></i>Selesai (Archived)</span></td>
                  <td class="text-right">
                    <div class="flex items-center justify-end gap-1">
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Melihat dokumen DOC-TRF-2025-0215" data-toast-type="info" title="Lihat" aria-label="Lihat dokumen"><i data-lucide="eye" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Mencetak dokumen DOC-TRF-2025-0215" data-toast-type="info" title="Cetak" aria-label="Cetak dokumen"><i data-lucide="printer" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Dokumen DOC-TRF-2025-0215 diunduh" title="Unduh" aria-label="Unduh dokumen"><i data-lucide="download" class="w-4 h-4"></i></button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div id="riwEmpty" class="hidden ai-empty">
            <div class="ai-empty-icon"><i data-lucide="search-x" class="w-6 h-6"></i></div>
            <div class="text-[13.5px] font-semibold text-slate-600">Tidak ada dokumen yang cocok</div>
            <p class="max-w-md text-[12.5px] text-slate-500">Coba ubah kata kunci, tipe dokumen, divisi, atau status — atau kembalikan semua filter ke kondisi awal.</p>
            <button type="button" id="emptyReset" class="ai-btn ai-btn-secondary mt-3"><i data-lucide="rotate-ccw" class="w-4 h-4"></i>Reset Filter</button>
          </div>

          <!-- Pagination -->
          <div class="mt-4 flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-slate-100">
            <div class="text-[12px] text-slate-500 font-medium"><span id="riwCountInfo">Menampilkan 5 dari 2.418 Riwayat Dokumen</span> &bull; Halaman 1 dari 484</div>
            <div class="flex items-center gap-1.5">
              <button class="ai-btn ai-btn-secondary opacity-50 cursor-not-allowed" disabled><i data-lucide="chevron-left" class="w-4 h-4"></i>Sebelumnya</button>
              <button class="w-9 h-9 rounded-lg bg-blue-600 text-white text-[12.5px] font-bold shadow-md shadow-blue-600/30">1</button>
              <button class="w-9 h-9 rounded-lg text-[12.5px] font-semibold text-slate-600 hover:bg-slate-100" data-toast="Halaman 2 dimuat" data-toast-type="info">2</button>
              <button class="w-9 h-9 rounded-lg text-[12.5px] font-semibold text-slate-600 hover:bg-slate-100" data-toast="Halaman 3 dimuat" data-toast-type="info">3</button>
              <span class="text-slate-400 px-1">...</span>
              <button class="w-9 h-9 rounded-lg text-[12.5px] font-semibold text-slate-600 hover:bg-slate-100" data-toast="Halaman 484 dimuat" data-toast-type="info">484</button>
              <button class="ai-btn ai-btn-secondary" data-toast="Halaman 2 dimuat" data-toast-type="info">Berikutnya<i data-lucide="chevron-right" class="w-4 h-4"></i></button>
            </div>
          </div>
        </section>

        <!-- ===== Info cards ===== -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="0">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="shield-check" class="w-5 h-5 text-blue-600"></i></div>
            <h3 class="mt-3.5 text-[15px] font-bold text-slate-800">Retensi Arsip &amp; Integritas Dokumen</h3>
            <p class="mt-2 text-[12.5px] text-slate-500 leading-relaxed">Seluruh berkas transaksi disimpan selama 5 tahun sesuai standar audit kepatuhan ISO 9001 &amp; perpajakan dengan integritas hash kriptografi SHA-256.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Kebijakan Retensi Arsip dibuka" data-toast-type="info">Pelajari Kebijakan Retensi <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></button>
          </div>
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="80">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center"><i data-lucide="refresh-cw" class="w-5 h-5 text-indigo-600"></i></div>
            <h3 class="mt-3.5 text-[15px] font-bold text-slate-800">Rekonsiliasi Otomatis ERP &amp; Finansial</h3>
            <p class="mt-2 text-[12.5px] text-slate-500 leading-relaxed">Sinkronisasi buku besar persediaan (inventory ledger) dengan SAP ERP dan jurnal akuntansi biaya secara realtime tiap pergantian shift kerja.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Status Sinkronisasi ERP: Semua sistem tersinkron" data-toast-type="info">Status Sinkronisasi ERP <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></button>
          </div>
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="160">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center"><i data-lucide="download" class="w-5 h-5 text-emerald-600"></i></div>
            <h3 class="mt-3.5 text-[15px] font-bold text-slate-800">Ekspor Laporan Khusus &amp; Pajak</h3>
            <p class="mt-2 text-[12.5px] text-slate-500 leading-relaxed">Butuh rekonsiliasi triangulasi atau pelaporan PPN/Faktur Logistik? Generate berkas audit khusus dalam format XLSX atau PDF resmi berstempel digital.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Template Laporan Audit diunduh">
              Unduh Template Laporan Audit <i data-lucide="download" class="w-3.5 h-3.5"></i></button>
          </div>
        </section>

        @endif

    </main>
</div>

<script>
    (function () {
      var rows = Array.prototype.slice.call(document.querySelectorAll("#riwBody tr"));
      var search = document.getElementById("riwSearch");
      var fTipe = document.getElementById("fTipe");
      var fDivisi = document.getElementById("fDivisi");
      var fStatus = document.getElementById("fStatus");
      var empty = document.getElementById("riwEmpty");
      var activeCat = "semua";
      var countInfo = document.getElementById("riwCountInfo");
      var unduhLabel = document.getElementById("unduhLabel");
      var resetBtn = document.getElementById("resetFilters");
      var emptyResetBtn = document.getElementById("emptyReset");
      var totalRiwayat = 2418;
      var initial = { tipe: fTipe.value, divisi: fDivisi.value, status: fStatus.value };

      function visibleRows() {
        return rows.filter(function (r) { return r.style.display !== "none"; });
      }

      /* Perbarui jumlah baris, status pilih-semua, dan label tombol unduh */
      function updateSelection() {
        var visible = visibleRows();
        var checks = [];
        visible.forEach(function (row) {
          var c = row.querySelector(".rowCheck");
          if (c) checks.push(c);
        });
        var n = checks.filter(function (c) { return c.checked; }).length;
        if (unduhLabel) unduhLabel.textContent = n > 0 ? "Unduh Terpilih (" + n + ")" : "Unduh Terpilih";
        if (checkAll) {
          checkAll.checked = checks.length > 0 && n === checks.length;
          checkAll.indeterminate = n > 0 && n < checks.length;
        }
      }

      function applyFilter() {
        var q = (search.value || "").trim().toLowerCase();
        var shown = 0;
        rows.forEach(function (r) {
          var ok = true;
          if (activeCat !== "semua" && r.getAttribute("data-cat") !== activeCat) ok = false;
          if (ok && fTipe.value !== "semua" && r.getAttribute("data-cat") !== fTipe.value) ok = false;
          if (ok && fDivisi.value !== "semua" && r.getAttribute("data-div") !== fDivisi.value) ok = false;
          if (ok && fStatus.value !== "semua" && r.getAttribute("data-status") !== fStatus.value) ok = false;
          if (ok && q && (r.getAttribute("data-text") + " " + r.textContent.toLowerCase()).indexOf(q) === -1) ok = false;
          r.style.display = ok ? "" : "none";
          if (ok) shown++;
        });
        empty.classList.toggle("hidden", shown > 0);
        /* baris yang tersembunyi filter tidak boleh tetap terpilih */
        rows.forEach(function (row) {
          if (row.style.display === "none") {
            var c = row.querySelector(".rowCheck");
            if (c && c.checked) c.checked = false;
          }
        });
        if (countInfo) {
          var difilter = (search.value || "").trim() !== "" ||
            fTipe.value !== initial.tipe || fDivisi.value !== initial.divisi || fStatus.value !== initial.status ||
            activeCat !== "semua";
          if (shown === 0) {
            countInfo.textContent = "Tidak ada dokumen yang cocok dari " + totalRiwayat.toLocaleString("id-ID") + " Riwayat Dokumen";
          } else if (difilter) {
            countInfo.textContent = "Menampilkan " + shown + " dari " + totalRiwayat.toLocaleString("id-ID") + " Riwayat Dokumen (difilter)";
          } else {
            countInfo.textContent = "Menampilkan " + shown + " baris dari " + totalRiwayat.toLocaleString("id-ID") + " Riwayat Dokumen";
          }
        }
        updateSelection();
      }

      // Sinkron pill (data-tabs) dengan filter kategori
      document.querySelector('[data-tabs="riwayat"]').addEventListener("ai:tabchange", function (e) {
        activeCat = e.detail.tab;
        applyFilter();
        var labels = { semua: "Semua Riwayat", masuk: "Barang Masuk / Inbound", keluar: "Barang Keluar / Outbound", adj: "Penyesuaian Opname", mutasi: "Mutasi Antar Hub / Rak" };
        window.aiToast("Filter riwayat: " + labels[e.detail.tab], "info");
      });

      search.addEventListener("input", applyFilter);
      [fTipe, fDivisi, fStatus].forEach(function (s) { s.addEventListener("change", applyFilter); });

      // Select-all checkbox
      var checkAll = document.getElementById("checkAll");
      checkAll.addEventListener("change", function () {
        visibleRows().forEach(function (row) {
          var c = row.querySelector(".rowCheck");
          if (c) c.checked = checkAll.checked;
        });
        updateSelection();
      });

      /* checkbox baris: label unduh ikut berubah */
      document.querySelectorAll(".rowCheck").forEach(function (c) {
        c.addEventListener("change", updateSelection);
      });

      /* Reset semua filter (tombol di filter bar & di empty state) */
      function resetFilters() {
        search.value = "";
        fTipe.value = initial.tipe;
        fDivisi.value = initial.divisi;
        fStatus.value = initial.status;
        activeCat = "semua";
        var group = document.querySelector('[data-tabs="riwayat"]');
        if (group) {
          group.querySelectorAll("[data-tab]").forEach(function (p) {
            p.classList.remove("ai-pill-active");
            p.setAttribute("aria-selected", "false");
          });
          var allPill = group.querySelector('[data-tab="semua"]');
          if (allPill) {
            allPill.classList.add("ai-pill-active");
            allPill.setAttribute("aria-selected", "true");
          }
        }
        applyFilter();
        if (window.aiToast) window.aiToast("Filter dikembalikan ke kondisi awal", "info");
      }
      [resetBtn, emptyResetBtn].forEach(function (b) {
        if (b) b.addEventListener("click", resetFilters);
      });

      // Unduh Terpilih
      document.getElementById("btnUnduh").addEventListener("click", function () {
        var n = visibleRows().filter(function (row) {
          var c = row.querySelector(".rowCheck");
          return c && c.checked;
        }).length;
        if (n === 0) window.aiToast("Pilih minimal 1 dokumen untuk diunduh.", "warn");
        else window.aiToast(n + " dokumen terpilih disiapkan untuk diunduh (PDF).");
      });

      applyFilter();
      window.aiRefresh();
    })();
</script>
</body>
</html>
