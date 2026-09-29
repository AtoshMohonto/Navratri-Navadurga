(function () {
    'use strict';

    // ---------- Service worker (offline shell) ----------
    // manifest.json and sw.js are both served from the app's public root, so
    // deriving sw.js from the manifest <link> href keeps this correct whether
    // the app lives at a domain root or a subfolder (e.g. /navadurga/).
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            var manifestLink = document.querySelector('link[rel="manifest"]');
            if (!manifestLink) return;
            var swUrl = new URL('sw.js', manifestLink.href).toString();
            navigator.serviceWorker.register(swUrl).catch(function () {
                /* PWA is a progressive enhancement; ignore failures */
            });
        });
    }

    // ---------- Theme toggle ----------
    var root = document.documentElement;
    var toggleBtn = document.getElementById('theme-toggle');

    function currentTheme() {
        var stored = null;
        try { stored = localStorage.getItem('navadurga_theme'); } catch (e) {}
        if (stored) return stored;
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    function setTheme(theme) {
        root.setAttribute('data-theme', theme);
        try { localStorage.setItem('navadurga_theme', theme); } catch (e) {}
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            setTheme(currentTheme() === 'dark' ? 'light' : 'dark');
        });
    }

    // ---------- Mobile nav ----------
    var menuToggle = document.getElementById('mobile-menu-toggle');
    var mobileNav = document.getElementById('mobile-nav');
    var mobileNavClose = document.getElementById('mobile-nav-close');

    function openMobileNav() {
        if (!mobileNav) return;
        mobileNav.classList.add('open');
        menuToggle && menuToggle.setAttribute('aria-expanded', 'true');
    }

    function closeMobileNav() {
        if (!mobileNav) return;
        mobileNav.classList.remove('open');
        menuToggle && menuToggle.setAttribute('aria-expanded', 'false');
    }

    menuToggle && menuToggle.addEventListener('click', openMobileNav);
    mobileNavClose && mobileNavClose.addEventListener('click', closeMobileNav);
    mobileNav && mobileNav.addEventListener('click', function (e) {
        if (e.target === mobileNav) closeMobileNav();
    });

    // ---------- Admin sidebar (mobile) ----------
    var adminSidebarToggle = document.getElementById('admin-sidebar-toggle');
    var adminSidebar = document.querySelector('.admin-sidebar');
    if (adminSidebarToggle && adminSidebar) {
        adminSidebarToggle.style.display = 'inline-flex';
        adminSidebarToggle.addEventListener('click', function () {
            adminSidebar.classList.toggle('open');
        });
    }

    // ---------- Generic AJAX POST helper (used by checklist / puja-status / bookmarks) ----------
    window.navadurgaPost = function (url, data) {
        data = Object.assign({}, data, { _csrf: window.CSRF_TOKEN || '' });
        var body = new URLSearchParams(data);
        return fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
            body: body.toString(),
        }).then(function (res) { return res.json(); });
    };

    // ---------- Print helper ----------
    document.querySelectorAll('[data-print]').forEach(function (btn) {
        btn.addEventListener('click', function () { window.print(); });
    });

    // ---------- Guest-mode localStorage checklist (for logged-out users) ----------
    window.navadurgaLocalChecklist = {
        key: 'navadurga_checklist',
        getAll: function () {
            try { return JSON.parse(localStorage.getItem(this.key)) || {}; } catch (e) { return {}; }
        },
        toggle: function (id) {
            var all = this.getAll();
            all[id] = !all[id];
            try { localStorage.setItem(this.key, JSON.stringify(all)); } catch (e) {}
            return all[id];
        },
    };
})();
