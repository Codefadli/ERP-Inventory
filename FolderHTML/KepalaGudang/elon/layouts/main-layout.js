/* =========================================
   ASTRO INVENTORY - MAIN LAYOUT JS
========================================= */

/* =========================================
   RENDER LUCIDE ICONS
========================================= */

window.refreshLucideIcons = function () {
  if (!window.lucide || typeof window.lucide.createIcons !== "function") {
    console.warn("Lucide belum tersedia. Periksa urutan pemanggilan script.");
    return false;
  }

  window.lucide.createIcons();
  return true;
};

/* =========================================
   TOGGLE SIDEBAR
========================================= */

window.toggleSidebar = function () {
  const sidebar = document.getElementById("sidebar");
  const backdrop = document.getElementById("sidebar-backdrop");

  if (!sidebar || !backdrop) return;

  sidebar.classList.toggle("open");
  backdrop.classList.toggle("show", sidebar.classList.contains("open"));
};

/* =========================================
   INITIALIZE MAIN LAYOUT
========================================= */

window.initMainLayout = function () {
  const sidebar = document.getElementById("sidebar");
  const backdrop = document.getElementById("sidebar-backdrop");

  if (!sidebar) return;

  /* MENU AKTIF */
  const activePage = document.body.dataset.active;

  document.querySelectorAll("[data-nav]").forEach((link) => {
    link.classList.toggle("active", link.dataset.nav === activePage);
  });

  /* TUTUP SIDEBAR SAAT KEMBALI KE DESKTOP */
  if (!window.__astroResizeInitialized) {
    window.addEventListener("resize", () => {
      const currentSidebar = document.getElementById("sidebar");
      const currentBackdrop = document.getElementById("sidebar-backdrop");

      if (window.innerWidth > 767) {
        currentSidebar?.classList.remove("open");
        currentBackdrop?.classList.remove("show");
      }
    });

    window.__astroResizeInitialized = true;
  }

  /* TUTUP SIDEBAR SETELAH MENU DIPILIH DI MOBILE */
  sidebar.querySelectorAll(".nav-link").forEach((link) => {
    if (link.dataset.sidebarListener === "true") return;

    link.addEventListener("click", () => {
      if (window.innerWidth <= 767) {
        sidebar.classList.remove("open");
        backdrop?.classList.remove("show");
      }
    });

    link.dataset.sidebarListener = "true";
  });

  /* RENDER SEMUA IKON LAYOUT */
  window.refreshLucideIcons();
};
