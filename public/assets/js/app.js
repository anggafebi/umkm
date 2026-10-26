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
    
  // Homepage product carousel
  document.querySelectorAll('[data-product-carousel]').forEach(carousel => {
    const track = carousel.querySelector('[data-product-track]');
    const cards = track
      ? Array.from(track.querySelectorAll('.product-carousel-card'))
      : [];

    const prev = carousel.querySelector('[data-product-prev]');
    const next = carousel.querySelector('[data-product-next]');
    const status = carousel.querySelector('[data-product-status]');

    if (!track || cards.length < 2 || !prev || !next) return;

    let pageIndex = 0;
    let timer = null;

    // Jumlah kartu yang terlihat mengikuti ukuran layar.
    const visibleCount = () => {
      if (window.innerWidth <= 620) return 1;
      if (window.innerWidth <= 930) return 2;
      return 3;
    };

    const pageCount = () =>
      Math.ceil(cards.length / visibleCount());

    // Geser track menuju kartu pertama pada halaman yang dipilih.
    const render = () => {
      const totalPages = pageCount();

      pageIndex = Math.max(
        0,
        Math.min(pageIndex, totalPages - 1)
      );

      const startIndex = pageIndex * visibleCount();
      const target = cards[startIndex];

      if (target) {
        const offset = target.offsetLeft - track.offsetLeft;
        track.style.transform =
          `translate3d(-${offset}px, 0, 0)`;
      }

      if (status) {
        status.textContent =
          `${String(pageIndex + 1).padStart(2, '0')} / ` +
          `${String(totalPages).padStart(2, '0')}`;
      }
    };

    // Pindah satu halaman dan kembali ke awal jika sudah di akhir.
    const move = direction => {
      const totalPages = pageCount();

      pageIndex =
        (pageIndex + direction + totalPages) % totalPages;

      render();
    };

    const stop = () => {
      if (timer !== null) {
        window.clearInterval(timer);
        timer = null;
      }
    };

    const start = () => {
      stop();

      if (
        reducedMotion ||
        document.hidden ||
        cards.length <= visibleCount()
      ) {
        return;
      }

      timer = window.setInterval(() => {
        move(1);
      }, 5500);
    };

    prev.addEventListener('click', () => {
      move(-1);
      start();
    });

    next.addEventListener('click', () => {
      move(1);
      start();
    });

    // Jeda saat pengguna mengarahkan kursor atau fokus ke carousel.
    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', start);
    carousel.addEventListener('focusin', stop);
    carousel.addEventListener('focusout', start);

    // Jangan jalankan animasi ketika tab browser tidak aktif.
    document.addEventListener('visibilitychange', () => {
      if (document.hidden) stop();
      else start();
    });

    window.addEventListener('resize', () => {
      render();
      start();
    }, { passive: true });

    render();
    start();
  });

})();
