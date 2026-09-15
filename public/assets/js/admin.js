(() => {
  const root = document.documentElement;
  const sidebar = document.getElementById('adminSidebar');
  const menu = document.querySelector('[data-admin-menu]');
  const backdrop = document.querySelector('[data-admin-backdrop]');
  const setTheme = value => { root.dataset.theme = value; root.style.colorScheme = value; localStorage.setItem('aditech-theme', value); };
  const closeSidebar = () => { sidebar?.classList.remove('open'); backdrop?.classList.remove('open'); document.body.classList.remove('admin-nav-open'); menu?.setAttribute('aria-expanded','false'); };
  const toggleSidebar = () => { const open=!sidebar?.classList.contains('open'); sidebar?.classList.toggle('open',open); backdrop?.classList.toggle('open',open); document.body.classList.toggle('admin-nav-open',open); menu?.setAttribute('aria-expanded',String(open)); };
  document.addEventListener('click', e => {
    if (e.target.closest('[data-theme-toggle]')) setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark');
    if (e.target.closest('[data-admin-menu]')) toggleSidebar();
    if (e.target.closest('[data-admin-backdrop]')) closeSidebar();
    if (window.innerWidth <= 820 && e.target.closest('.admin-nav a')) closeSidebar();
    const opener = e.target.closest('[data-modal-open]'); if (opener) document.getElementById(opener.dataset.modalOpen)?.classList.add('open');
    if (e.target.closest('[data-modal-close]')) e.target.closest('.modal')?.classList.remove('open');
    if (e.target.classList.contains('modal')) e.target.classList.remove('open');
  });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeSidebar(); document.querySelectorAll('.modal.open').forEach(m => m.classList.remove('open')); } });
  window.addEventListener('resize',()=>{if(window.innerWidth>820)closeSidebar()},{passive:true});
})();
