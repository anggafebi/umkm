(() => {
  const root = document.documentElement;
  const nav = document.querySelector('[data-nav]');
  const menuButton = document.querySelector('[data-mobile-menu]');
  const backdrop = document.querySelector('[data-nav-backdrop]');
  const header = document.querySelector('[data-header]');
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const readTheme = () => {
    try { return localStorage.getItem('aditech-theme'); }
    catch (_) { return null; }
  };

  const setTheme = theme => {
    if (!['light', 'dark'].includes(theme)) return;
    root.dataset.theme = theme;
    root.style.colorScheme = theme;
    try { localStorage.setItem('aditech-theme', theme); }
    catch (_) { /* Theme still works for the current page when storage is unavailable. */ }
  };

  const closeMenu = () => {
    nav?.classList.remove('active');
    backdrop?.classList.remove('active');
    document.body.classList.remove('nav-open');
    menuButton?.setAttribute('aria-expanded', 'false');
    menuButton?.setAttribute('aria-label', 'Buka menu navigasi');
  };

  const toggleMenu = () => {
    if (!nav || !menuButton) return;
    const open = !nav.classList.contains('active');
    nav.classList.toggle('active', open);
    backdrop?.classList.toggle('active', open);
    document.body.classList.toggle('nav-open', open);
    menuButton.setAttribute('aria-expanded', String(open));
    menuButton.setAttribute('aria-label', open ? 'Tutup menu navigasi' : 'Buka menu navigasi');
  };

  document.addEventListener('click', event => {
    if (event.target.closest('[data-theme-toggle]')) {
      setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark');
    }
    if (event.target.closest('[data-mobile-menu]')) toggleMenu();
    if (event.target.closest('[data-nav] a') || event.target.closest('[data-nav-backdrop]')) closeMenu();
  });

  document.addEventListener('keydown', event => {
    if (event.key === 'Escape') closeMenu();
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 760) closeMenu();
  }, { passive: true });

  const updateHeader = () => header?.classList.toggle('scrolled', window.scrollY > 16);
  window.addEventListener('scroll', updateHeader, { passive: true });
  updateHeader();

  if (!reducedMotion && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.08 });
    document.querySelectorAll('.reveal').forEach(element => observer.observe(element));
  } else {
    document.querySelectorAll('.reveal').forEach(element => element.classList.add('visible'));
  }

  const slider = document.querySelector('[data-slider]');
  if (slider && slider.children.length > 1 && !reducedMotion) {
    let index = 0;
    let timer = null;
    const start = () => {
      if (timer || document.hidden) return;
      timer = window.setInterval(() => {
        if (document.hidden || !slider.children.length) return;
        index = (index + 1) % slider.children.length;
        slider.children[index].scrollIntoView({ behavior: 'smooth', inline: 'start', block: 'nearest' });
      }, 6000);
    };
    const stop = () => {
      if (timer) window.clearInterval(timer);
      timer = null;
    };
    slider.addEventListener('mouseenter', stop);
    slider.addEventListener('mouseleave', start);
    slider.addEventListener('focusin', stop);
    slider.addEventListener('focusout', start);
    document.addEventListener('visibilitychange', () => document.hidden ? stop() : start());
    start();
  }
})();
