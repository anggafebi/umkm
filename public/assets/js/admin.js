(() => {
  const root = document.documentElement;
  const sidebar = document.getElementById('adminSidebar');
  const menu = document.querySelector('.admin-topbar [data-admin-menu]');
  const backdrop = document.querySelector('[data-admin-backdrop]');

  const setTheme = value => {
    root.dataset.theme = value;
    root.style.colorScheme = value;
    try { localStorage.setItem('aditech-theme', value); }
    catch (_) { /* The selected theme still applies to the current page. */ }
  };

  const closeSidebar = () => {
    sidebar?.classList.remove('open');
    backdrop?.classList.remove('open');
    document.body.classList.remove('admin-nav-open');
    menu?.setAttribute('aria-expanded', 'false');
  };

  const toggleSidebar = () => {
    if (!sidebar) return;
    const open = !sidebar.classList.contains('open');
    sidebar.classList.toggle('open', open);
    backdrop?.classList.toggle('open', open);
    document.body.classList.toggle('admin-nav-open', open);
    menu?.setAttribute('aria-expanded', String(open));
  };

  const openModal = modal => {
    if (!modal) return;
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('admin-modal-open');
    window.requestAnimationFrame(() => modal.querySelector('[data-modal-close], input, select, textarea, button')?.focus());
  };

  const closeModal = modal => {
    if (!modal) return;
    modal.classList.remove('open');
    modal.setAttribute('aria-hidden', 'true');
    if (!document.querySelector('.modal.open')) document.body.classList.remove('admin-modal-open');
  };

  document.querySelectorAll('.modal').forEach(modal => modal.setAttribute('aria-hidden', modal.classList.contains('open') ? 'false' : 'true'));

  document.addEventListener('click', event => {
    if (event.target.closest('[data-theme-toggle]')) setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark');
    if (event.target.closest('[data-admin-menu]')) toggleSidebar();
    if (event.target.closest('[data-admin-backdrop]')) closeSidebar();
    if (window.innerWidth <= 980 && event.target.closest('.admin-nav a')) closeSidebar();

    const opener = event.target.closest('[data-modal-open]');
    if (opener) openModal(document.getElementById(opener.dataset.modalOpen));

    const closer = event.target.closest('[data-modal-close]');
    if (closer) closeModal(closer.closest('.modal'));
    if (event.target.classList.contains('modal')) closeModal(event.target);
  });

  document.addEventListener('keydown', event => {
    if (event.key !== 'Escape') return;
    closeSidebar();
    document.querySelectorAll('.modal.open').forEach(closeModal);
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 980) closeSidebar();
  }, { passive: true });
})();
