(() => {
  const root = document.documentElement;
  const nav = document.querySelector('[data-nav]');
  const menuButton = document.querySelector('[data-mobile-menu]');
  const backdrop = document.querySelector('[data-nav-backdrop]');
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const setTheme = theme => {
    root.dataset.theme = theme;
    root.style.colorScheme = theme;
    localStorage.setItem('aditech-theme', theme);
  };

  const closeMenu = () => {
    nav?.classList.remove('active');
    backdrop?.classList.remove('active');
    document.body.classList.remove('nav-open');
    menuButton?.setAttribute('aria-expanded', 'false');
  };

  const toggleMenu = () => {
    const open = !nav?.classList.contains('active');
    nav?.classList.toggle('active', open);
    backdrop?.classList.toggle('active', open);
    document.body.classList.toggle('nav-open', open);
    menuButton?.setAttribute('aria-expanded', String(open));
  };

  document.addEventListener('click', e => {
    if (e.target.closest('[data-theme-toggle]')) setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark');
    if (e.target.closest('[data-mobile-menu]')) toggleMenu();
    if (e.target.closest('[data-nav] a') || e.target.closest('[data-nav-backdrop]')) closeMenu();
  });

  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenu(); });
  window.addEventListener('resize', () => { if (window.innerWidth > 760) closeMenu(); }, {passive:true});

  const header = document.querySelector('[data-header]');
  const updateHeader = () => header?.classList.toggle('scrolled', window.scrollY > 16);
  window.addEventListener('scroll', updateHeader, {passive:true});
  updateHeader();

  if (!reducedMotion && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => entries.forEach(x => {
      if (x.isIntersecting) { x.target.classList.add('visible'); observer.unobserve(x.target); }
    }), {threshold:.08});
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
  } else {
    document.querySelectorAll('.reveal').forEach(el => el.classList.add('visible'));
  }

  const slider = document.querySelector('[data-slider]');
  if (slider && slider.children.length > 1 && !reducedMotion) {
    let i = 0;
    let timer = null;
    const start = () => { timer = window.setInterval(() => {
      if (document.hidden) return;
      i = (i + 1) % slider.children.length;
      slider.children[i].scrollIntoView({behavior:'smooth', inline:'start', block:'nearest'});
    }, 6000); };
    const stop = () => { if (timer) window.clearInterval(timer); timer = null; };
    slider.addEventListener('mouseenter', stop);
    slider.addEventListener('mouseleave', start);
    slider.addEventListener('focusin', stop);
    slider.addEventListener('focusout', start);
    start();
  }
})();
