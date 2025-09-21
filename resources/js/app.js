import './bootstrap';

(function initNavigation() {
  const bindOnce = (el, type, handler, options) => {
    if (!el) return;
    const key = `__bound_${type}`;
    if (el[key]) return; // prevent double binding
    el.addEventListener(type, handler, options || false);
    el[key] = true;
  };

  const init = () => {
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileOverlay = document.getElementById('mobile-menu-overlay');
    const iconMenu = document.getElementById('icon-menu');
    const iconClose = document.getElementById('icon-close');

    // Helper: compute and set mobile drawer position under navbar
    const positionMobileMenu = () => {
      if (!mobileMenu) return;
      const nav = document.querySelector('nav');
      const navHeight = nav ? nav.offsetHeight : 64; // fallback ~top-16
      mobileMenu.style.top = navHeight + 'px';
      mobileMenu.style.maxHeight = `calc(100vh - ${navHeight}px)`;
      mobileMenu.style.overflowY = 'auto';
    };

    if (mobileMenuButton && mobileMenu) {
      const openMobile = () => {
        positionMobileMenu();
        mobileMenu.classList.remove('hidden');
        if (mobileOverlay) mobileOverlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        mobileMenuButton.setAttribute('aria-expanded', 'true');
        if (iconMenu) iconMenu.classList.add('hidden');
        if (iconClose) iconClose.classList.remove('hidden');
      };
      const closeMobile = () => {
        mobileMenu.classList.add('hidden');
        if (mobileOverlay) mobileOverlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        mobileMenuButton.setAttribute('aria-expanded', 'false');
        if (iconMenu) iconMenu.classList.remove('hidden');
        if (iconClose) iconClose.classList.add('hidden');
      };

      bindOnce(mobileMenuButton, 'click', (e) => {
        e.stopPropagation();
        const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
        if (isExpanded) closeMobile(); else openMobile();
      });

      if (mobileOverlay) bindOnce(mobileOverlay, 'click', closeMobile);

      // Close on link click
      const links = mobileMenu.querySelectorAll('a');
      links.forEach((link) => bindOnce(link, 'click', closeMobile));

      // Close when clicking outside
      bindOnce(document, 'click', (evt) => {
        const target = evt.target;
        if (!mobileMenu.contains(target) && !mobileMenuButton.contains(target)) {
          closeMobile();
        }
      });

      // Close on Escape
      bindOnce(document, 'keydown', (e) => {
        if (e.key === 'Escape') closeMobile();
      });

      // Recompute position on resize; close on desktop
      bindOnce(window, 'resize', () => {
        if (window.innerWidth >= 768) {
          closeMobile();
        } else if (!mobileMenu.classList.contains('hidden')) {
          positionMobileMenu();
        }
      });

      // Initial compute in case nav height differs
      positionMobileMenu();
    }

    // Click dropdowns (desktop)
    document.querySelectorAll('[data-dropdown="user"]').forEach((wrapper) => {
      const btn = wrapper.querySelector('[data-dropdown-button]');
      const panel = wrapper.querySelector('[data-dropdown-panel]');
      if (!btn || !panel) return;
      let open = false;
      const openPanel = () => {
        panel.style.opacity = '1';
        panel.style.pointerEvents = 'auto';
        panel.style.transform = 'translateY(0)';
        open = true;
      };
      const closePanel = () => {
        panel.style.opacity = '0';
        panel.style.pointerEvents = 'none';
        panel.style.transform = 'translateY(4px)';
        open = false;
      };
      bindOnce(btn, 'click', (e) => {
        e.stopPropagation();
        open ? closePanel() : openPanel();
      });
      bindOnce(document, 'click', (e) => {
        if (!wrapper.contains(e.target)) closePanel();
      });
      bindOnce(document, 'keydown', (e) => { if (e.key === 'Escape') closePanel(); });
      bindOnce(window, 'resize', () => { if (window.innerWidth < 768) closePanel(); });
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
