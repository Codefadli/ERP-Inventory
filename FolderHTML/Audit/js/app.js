/* ============================================================
   ASTRO Inventory — Shared interaction layer
   Vanilla JS, no deps. Tailwind handles layout/visuals.
   ============================================================ */
(function () {
  'use strict';

  /* ---------- Toast ---------- */
  function toast(msg, type) {
    let c = document.getElementById('toast-container');
    if (!c) { c = document.createElement('div'); c.id = 'toast-container'; document.body.appendChild(c); }
    const t = document.createElement('div');
    t.className = 'toast ' + (type || '');
    t.textContent = msg;
    c.appendChild(t);
    setTimeout(function () { t.style.opacity = '0'; t.style.transition = 'opacity .3s'; setTimeout(function(){ t.remove(); }, 300); }, 3200);
  }
  window.toast = toast;

  /* ---------- Mobile sidebar drawer ---------- */
  function initDrawer() {
    const trig = document.querySelector('[data-drawer-trigger]');
    const sb = document.querySelector('.sidebar-left');
    const back = document.querySelector('.drawer-backdrop');
    if (!trig || !sb) return;
    function open() { sb.classList.add('drawer','open'); if(back) back.classList.add('open'); }
    function close() { sb.classList.remove('open'); if(back) back.classList.remove('open'); }
    trig.addEventListener('click', function(){ sb.classList.contains('open') ? close() : open(); });
    if (back) back.addEventListener('click', close);
  }

  /* ---------- Dropdowns (notification / profile) ---------- */
  function initDropdowns() {
    document.querySelectorAll('[data-dropdown]').forEach(function (btn) {
      const target = btn.getAttribute('data-dropdown');
      const menu = document.querySelector('[data-dropdown-menu="' + target + '"]');
      if (!menu) return;
      btn.addEventListener('click', function (e) {
        e.stopPropagation();
        document.querySelectorAll('.dropdown.open').forEach(function (m){ if (m !== menu) m.classList.remove('open'); });
        menu.classList.toggle('open');
      });
    });
    document.addEventListener('click', function () {
      document.querySelectorAll('.dropdown.open').forEach(function (m){ m.classList.remove('open'); });
    });
    document.querySelectorAll('.dropdown').forEach(function (m){ m.addEventListener('click', function(e){ e.stopPropagation(); }); });
  }

  /* ---------- Disabled sidebar items ---------- */
  function initDisabledNav() {
    document.querySelectorAll('.sidebar-item.disabled').forEach(function (a) {
      a.addEventListener('click', function (e) {
        e.preventDefault();
        toast('Halaman belum tersedia (tidak memiliki referensi PNG).', 'warn');
      });
    });
  }

  /* ---------- Modals ---------- */
  window.openModal = function (id) {
    const m = document.getElementById(id);
    if (m) m.classList.add('open');
  };
  window.closeModal = function (id) {
    const m = document.getElementById(id);
    if (m) m.classList.remove('open');
  };
  function initModals() {
    document.querySelectorAll('.modal-overlay').forEach(function (m) {
      m.addEventListener('click', function (e) { if (e.target === m) m.classList.remove('open'); });
    });
    document.querySelectorAll('[data-close-modal]').forEach(function (b) {
      b.addEventListener('click', function () {
        const m = b.closest('.modal-overlay'); if (m) m.classList.remove('open');
      });
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(function (m){ m.classList.remove('open'); });
    });
  }

  /* ---------- Tabs ---------- */
  window.initTabs = function (container) {
    const root = typeof container === 'string' ? document.getElementById(container) : container;
    if (!root) return;
    const btns = root.querySelectorAll('[data-tab]');
    const panels = root.querySelectorAll('[data-tab-panel]');
    btns.forEach(function (b) {
      b.addEventListener('click', function () {
        const name = b.getAttribute('data-tab');
        btns.forEach(function (x){ x.classList.remove('active'); });
        b.classList.add('active');
        panels.forEach(function (p){
          p.style.display = (p.getAttribute('data-tab-panel') === name) ? '' : 'none';
        });
      });
    });
  };

  /* ---------- Table filtering / search ---------- */
  /* Rows carry data attributes; selects/search filter them. */
  window.initTableFilter = function (opts) {
    const table = document.getElementById(opts.tableId);
    if (!table) return;
    const tbody = table.querySelector('tbody');
    const rows = Array.prototype.slice.call(tbody.querySelectorAll('tr'));
    const search = opts.searchId ? document.getElementById(opts.searchId) : null;
    const selects = (opts.selects || []).map(function (s) {
      return { el: document.getElementById(s.id), attr: s.attr };
    });

    function visible(r) {
      if (search) {
        const q = (search.value || '').toLowerCase().trim();
        if (q && r.textContent.toLowerCase().indexOf(q) === -1) return false;
      }
      for (let i = 0; i < selects.length; i++) {
        const v = selects[i].el ? selects[i].el.value : '';
        if (v && (r.getAttribute('data-' + selects[i].attr) || '').toLowerCase() !== String(v).toLowerCase()) return false;
      }
      if (opts.checkboxId) {
        const cb = document.getElementById(opts.checkboxId);
        if (cb && cb.checked) {
          const flag = r.getAttribute('data-flag') || '';
          if (flag.indexOf('anomali') === -1) return false;
        }
      }
      return true;
    }
    function apply() {
      let count = 0;
      rows.forEach(function (r) {
        const ok = visible(r);
        r.style.display = ok ? '' : 'none';
        if (ok) count++;
      });
      const info = document.getElementById(opts.countId);
      if (info) info.textContent = count;
    }
    if (search) search.addEventListener('input', apply);
    selects.forEach(function (s){ if (s.el) s.el.addEventListener('change', apply); });
    if (opts.checkboxId) { const cb = document.getElementById(opts.checkboxId); if (cb) cb.addEventListener('change', apply); }
    const reset = opts.resetId ? document.getElementById(opts.resetId) : null;
    if (reset) reset.addEventListener('click', function () {
      if (search) search.value = '';
      selects.forEach(function (s){ if (s.el) s.el.value = ''; });
      if (opts.checkboxId) { const cb = document.getElementById(opts.checkboxId); if (cb) cb.checked = false; }
      apply();
    });
    apply();
    return { reapply: apply };
  };

  /* ---------- Client-side pagination (simple) ---------- */
  window.initPagination = function (opts) {
    const table = document.getElementById(opts.tableId);
    if (!table) return;
    const tbody = table.querySelector('tbody');
    const allRows = Array.prototype.slice.call(tbody.querySelectorAll('tr'));
    let perPage = opts.perPage || 10;
    let page = 1;
    const wrap = document.getElementById(opts.controlsId);
    function filteredRows() {
      return allRows.filter(function (r){ return r.style.display !== 'none'; });
    }
    function render() {
      const fr = filteredRows();
      const pages = Math.max(1, Math.ceil(fr.length / perPage));
      if (page > pages) page = pages;
      fr.forEach(function (r, idx) {
        const start = (page - 1) * perPage;
        r.style.display = (idx >= start && idx < start + perPage) ? '' : 'none';
      });
      if (wrap) {
        const info = opts.infoId ? document.getElementById(opts.infoId) : null;
        if (info) {
          const from = fr.length ? (page - 1) * perPage + 1 : 0;
          const to = Math.min(page * perPage, fr.length);
          info.textContent = 'Menampilkan ' + from + ' - ' + to + ' dari ' + fr.length + ' ' + (opts.unit || 'data');
        }
        let html = '';
        const prev = page <= 1;
        html += '<button ' + (prev ? 'disabled' : '') + ' class="px-3 py-1 border border-gray-300 rounded text-xs lg:text-sm ' + (prev ? 'text-gray-400 cursor-not-allowed' : 'hover:bg-gray-50') + ' data-pg="' + (page - 1) + '">Sebelumnya</button>';
        for (let p = 1; p <= pages; p++) {
          html += '<button class="px-3 py-1 rounded text-xs lg:text-sm ' + (p === page ? 'bg-blue-600 text-white' : 'border border-gray-300 hover:bg-gray-50') + '" data-pg="' + p + '">' + p + '</button>';
        }
        const next = page >= pages;
        html += '<button ' + (next ? 'disabled' : '') + ' class="px-3 py-1 border border-gray-300 rounded text-xs lg:text-sm ' + (next ? 'text-gray-400 cursor-not-allowed' : 'bg-gray-100 hover:bg-gray-200') + ' data-pg="' + (page + 1) + '">Berikutnya</button>';
        wrap.innerHTML = html;
        wrap.querySelectorAll('[data-pg]').forEach(function (b) {
          b.addEventListener('click', function () {
            const v = parseInt(b.getAttribute('data-pg'), 10); if (!isNaN(v)) { page = v; render(); }
          });
        });
      }
    }
    return { render: render, setPage: function (p) { page = p; render(); } };
  };

  /* ---------- Boot ---------- */
  document.addEventListener('DOMContentLoaded', function () {
    initDrawer();
    initDropdowns();
    initDisabledNav();
    initModals();
  });
})();
