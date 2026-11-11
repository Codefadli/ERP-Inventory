/* =========================================
   ASTRO INVENTORY - MAIN LAYOUT JS
   STABLE NAVIGATION VERSION
========================================= */

"use strict";

/* =========================================
   RENDER LUCIDE ICONS
========================================= */

window.refreshLucideIcons = function () {
  if (!window.lucide || typeof window.lucide.createIcons !== "function") {
    console.warn("Lucide belum tersedia.");
    return false;
  }

  window.lucide.createIcons({
    attrs: {
      "stroke-width": 1.8,
    },
  });

  return true;
};

/* =========================================
   GET ROOT FOLDER PAGES
========================================= */

window.getAstroPagesRoot = function () {
  const pathname = window.location.pathname;
  const marker = "/pages/";
  const index = pathname.lastIndexOf(marker);

  if (index !== -1) {
    return pathname.substring(0, index + marker.length);
  }

  console.warn("Folder /pages/ tidak ditemukan pada URL:", pathname);

  return null;
};

/* =========================================
   RESOLVE PAGE URL
========================================= */

window.resolveAstroPageUrl = function (pagePath) {
  if (!pagePath) return null;

  const pagesRoot = window.getAstroPagesRoot();

  if (!pagesRoot) return null;

  const cleanPath = String(pagePath)
    .trim()
    .replace(/\\/g, "/")
    .replace(/^\/+/, "");

  if (!cleanPath || cleanPath.includes("..")) {
    console.error("Path halaman tidak valid:", pagePath);
    return null;
  }

  return new URL(cleanPath, window.location.origin + pagesRoot).href;
};

/* =========================================
   INITIALIZE ALL NAVIGATION LINKS
========================================= */

window.initSidebarPaths = function () {
  const links = document.querySelectorAll("[data-page-path]");

  links.forEach(function (link) {
    const pagePath = link.dataset.pagePath;
    const targetUrl = window.resolveAstroPageUrl(pagePath);

    if (!targetUrl) {
      console.error("Gagal menentukan alamat halaman:", pagePath);
      return;
    }

    link.dataset.resolvedPageUrl = targetUrl;

    if (link.tagName === "A") {
      link.href = targetUrl;
    }
  });
};

/* =========================================
   ACTIVE SIDEBAR MENU
========================================= */

window.setActiveSidebarMenu = function () {
  const activePage = document.body.dataset.active || "";

  const links = document.querySelectorAll(".sidebar-navigation [data-nav]");

  links.forEach(function (link) {
    const isActive = link.dataset.nav === activePage;

    link.classList.toggle("active", isActive);
    link.classList.toggle("nav-active", isActive);

    if (isActive) {
      link.setAttribute("aria-current", "page");
    } else {
      link.removeAttribute("aria-current");
    }
  });
};

/* =========================================
   SIDEBAR TOGGLE
========================================= */

window.toggleSidebar = function () {
  const sidebar = document.getElementById("sidebar");
  const backdrop = document.getElementById("sidebar-backdrop");

  if (!sidebar || !backdrop) return;

  const isOpen = !sidebar.classList.contains("open");

  sidebar.classList.toggle("open", isOpen);
  backdrop.classList.toggle("show", isOpen);

  document.body.classList.toggle("sidebar-open", isOpen);
};

/* =========================================
   CLOSE SIDEBAR
========================================= */

window.closeSidebar = function () {
  const sidebar = document.getElementById("sidebar");
  const backdrop = document.getElementById("sidebar-backdrop");

  if (sidebar) {
    sidebar.classList.remove("open");
  }

  if (backdrop) {
    backdrop.classList.remove("show");
  }

  document.body.classList.remove("sidebar-open");
};

/* =========================================
   TOPBAR NAVIGATION
========================================= */

window.initTopbarNavigation = function () {
  const buttons = document.querySelectorAll("[data-topbar-navigation]");

  buttons.forEach(function (button) {
    if (button.dataset.navigationInitialized === "true") {
      return;
    }

    button.addEventListener("click", function () {
      const targetUrl = button.dataset.resolvedPageUrl;

      if (!targetUrl) {
        console.error("URL navigasi Topbar tidak ditemukan.");
        return;
      }

      window.location.assign(targetUrl);
    });

    button.dataset.navigationInitialized = "true";
  });
};

/* =========================================
   SIDEBAR EVENTS
========================================= */

window.initSidebarEvents = function () {
  const sidebar = document.getElementById("sidebar");
  const backdrop = document.getElementById("sidebar-backdrop");

  if (!sidebar) return;

  if (backdrop && backdrop.dataset.initialized !== "true") {
    backdrop.addEventListener("click", function () {
      window.closeSidebar();
    });

    backdrop.dataset.initialized = "true";
  }

  if (sidebar.dataset.navigationInitialized !== "true") {
    sidebar.addEventListener("click", function (event) {
      const link = event.target.closest(".nav-link");

      if (!link) return;

      if (window.innerWidth <= 767) {
        window.closeSidebar();
      }
    });

    sidebar.dataset.navigationInitialized = "true";
  }
};

/* =========================================
   WINDOW RESIZE
========================================= */

window.initSidebarResize = function () {
  if (window.__astroResizeInitialized) return;

  window.addEventListener("resize", function () {
    if (window.innerWidth > 767) {
      window.closeSidebar();
    }
  });

  window.__astroResizeInitialized = true;
};

/* =========================================
   INITIALIZE MAIN LAYOUT
========================================= */

window.initMainLayout = function () {
  const sidebar = document.getElementById("sidebar");

  if (!sidebar) {
    console.warn("MainLayout belum dimuat. Sidebar tidak ditemukan.");
    return false;
  }

  window.initSidebarPaths();
  window.setActiveSidebarMenu();
  window.initSidebarEvents();
  window.initTopbarNavigation();
  window.initSidebarResize();
  window.refreshLucideIcons();

  return true;
};

/* =========================================
   AUTO INITIALIZATION
========================================= */

(function () {
  function initialize() {
    if (document.getElementById("sidebar")) {
      window.initMainLayout();
    }
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initialize, { once: true });
  } else {
    initialize();
  }
})();
