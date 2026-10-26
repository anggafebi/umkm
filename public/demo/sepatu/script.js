(() => {
  'use strict';
  const products = [
    {id:1,name:'Retro Runner Beige',category:'Running',price:649000,image:'beige-retro.jpg',tag:'Best seller',color:'Cream Beige',sizes:'39-44',material:'Mesh & suede',note:'Gaya retro dengan nuansa netral.',description:'Sneaker retro bernuansa beige dengan siluet sporty, ringan, dan nyaman untuk aktivitas harian maupun gaya kasual.'},
    {id:2,name:'Classic Court White',category:'Casual',price:589000,image:'white-classic.jpg',tag:'Timeless',color:'Off White',sizes:'39-44',material:'Leather & suede',note:'Desain bersih untuk tampilan minimal.',description:'Sneaker kasual bergaya court dengan tampilan bersih, mudah dipadukan, dan cocok untuk penggunaan sehari-hari.'},
    {id:3,name:'Mono Glide Black',category:'Running',price:699000,image:'black-runner.jpg',tag:'Performance',color:'Midnight Black',sizes:'40-45',material:'Breathable mesh',note:'Silhouette tegas dengan warna hitam penuh.',description:'Sepatu running serba hitam dengan bantalan empuk dan tampilan modern untuk gaya aktif yang tetap rapi.'},
    {id:4,name:'Trail Edge Olive',category:'Outdoor',price:739000,image:'olive-trail.jpg',tag:'Outdoor',color:'Olive Khaki',sizes:'40-45',material:'Mesh & rugged sole',note:'Siap untuk gaya outdoor dan urban.',description:'Model trail dengan outsole tebal dan detail panel berlapis, cocok untuk eksplorasi ringan dan tampilan utilitarian.'},
    {id:5,name:'Sky Pace Blue',category:'Running',price:629000,image:'blue-sport.jpg',tag:'Fresh tone',color:'Soft Blue',sizes:'39-44',material:'Air mesh',note:'Warna cerah dengan kenyamanan tinggi.',description:'Sneaker running warna biru muda dengan struktur ringan dan tampilan bersih untuk gaya santai dan aktif.'},
    {id:6,name:'Heritage Leather Brown',category:'Casual',price:679000,image:'brown-leather.jpg',tag:'Premium',color:'Tan Brown',sizes:'39-44',material:'Synthetic leather',note:'Tampilan klasik dengan sentuhan premium.',description:'Sneaker kulit cokelat dengan karakter klasik, cocok untuk tampilan smart casual yang tetap santai.'}
  ];

  const $ = id => document.getElementById(id);
  const money = value => 'Rp' + Math.round(Number(value) || 0).toLocaleString('id-ID');
  const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
  const STORAGE_KEY = 'ritmo-retro-shoe-cart-v1';
  const state = {
    filter: 'Semua',
    query: '',
    sort: 'featured',
    activeProduct: null,
    cart: (() => { try { return JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}') || {}; } catch (_) { return {}; } })()
  };
  let toastTimer;

  function saveCart() {
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(state.cart)); } catch (_) {}
  }

  function toast(message) {
    const el = $('toast');
    el.textContent = message;
    el.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => el.classList.remove('show'), 2200);
  }

  function currentProducts() {
    let list = products.filter(p => (
      (state.filter === 'Semua' || p.category === state.filter) &&
      `${p.name} ${p.category} ${p.color} ${p.material}`.toLowerCase().includes(state.query.toLowerCase().trim())
    ));
    if (state.sort === 'price-low') list.sort((a, b) => a.price - b.price);
    else if (state.sort === 'price-high') list.sort((a, b) => b.price - a.price);
    else if (state.sort === 'name') list.sort((a, b) => a.name.localeCompare(b.name, 'id'));
    return list;
  }

  function renderProducts() {
    const list = currentProducts();
    $('productGrid').innerHTML = list.map(p => `
      <article class="product-card">
        <button class="product-photo" type="button" data-detail="${p.id}" aria-label="Lihat detail ${esc(p.name)}">
          <img src="assets/products/${p.image}" alt="${esc(p.name)}">
          <span class="product-tag">${esc(p.tag)}</span>
        </button>
        <div class="product-info">
          <span class="product-category">${esc(p.category)} / ${esc(p.color)}</span>
          <h3>${esc(p.name)}</h3>
          <p class="product-meta">${esc(p.sizes)} · ${esc(p.material)}</p>
          <p class="product-note">${esc(p.note)}</p>
          <div class="product-bottom">
            <strong class="product-price">${money(p.price)}</strong>
            <button class="add-button" type="button" data-add="${p.id}">Tambah <span>＋</span></button>
          </div>
        </div>
      </article>
    `).join('');
    $('productCount').textContent = String(list.length).padStart(2, '0');
    $('emptyState').hidden = list.length !== 0;
    $('productGrid').hidden = list.length === 0;
    document.querySelectorAll('[data-filter]').forEach(btn => btn.classList.toggle('active', btn.dataset.filter === state.filter));
  }

  function cartRows() {
    return Object.entries(state.cart)
      .map(([id, qty]) => ({ product: products.find(p => p.id === Number(id)), qty: Number(qty) }))
      .filter(item => item.product && item.qty > 0);
  }

  function cartCount() {
    return cartRows().reduce((sum, row) => sum + row.qty, 0);
  }

  function cartTotal() {
    return cartRows().reduce((sum, row) => sum + (row.product.price * row.qty), 0);
  }

  function renderCart() {
    const rows = cartRows();
    $('cartCount').textContent = String(cartCount());
    $('drawerCount').textContent = `(${cartCount()})`;
    $('cartSubtotal').textContent = money(cartTotal());
    $('checkoutTotal').textContent = money(cartTotal());
    $('cartItems').innerHTML = rows.map(({product:p, qty}) => `
      <div class="cart-row">
        <img src="assets/products/${p.image}" alt="${esc(p.name)}">
        <div>
          <h3>${esc(p.name)}</h3>
          <small>${esc(p.color)} · ${esc(p.sizes)}</small>
          <strong class="row-price">${money(p.price * qty)}</strong>
          <div class="qty-row">
            <button type="button" data-qty="${p.id}" data-delta="-1" aria-label="Kurangi">−</button>
            <span>${qty}</span>
            <button type="button" data-qty="${p.id}" data-delta="1" aria-label="Tambah">＋</button>
            <button class="remove-link" type="button" data-remove="${p.id}">Hapus</button>
          </div>
        </div>
      </div>
    `).join('');
    $('cartEmpty').classList.toggle('show', rows.length === 0);
    $('drawerBottom').hidden = rows.length === 0;
  }

  function openOverlay(id) {
    $(id).classList.add('open');
    $(id).setAttribute('aria-hidden', 'false');
    document.body.classList.add('locked');
  }

  function closeOverlay(id) {
    $(id).classList.remove('open');
    $(id).setAttribute('aria-hidden', 'true');
    if (!document.querySelector('.overlay.open')) document.body.classList.remove('locked');
  }

  function addToCart(id) {
    const product = products.find(p => p.id === Number(id));
    if (!product) return;
    state.cart[product.id] = (Number(state.cart[product.id]) || 0) + 1;
    saveCart();
    renderCart();
    toast(`${product.name} ditambahkan ke keranjang.`);
  }

  function showDetail(id) {
    const p = products.find(item => item.id === Number(id));
    if (!p) return;
    state.activeProduct = p;
    $('modalImage').src = 'assets/products/' + p.image;
    $('modalImage').alt = p.name;
    $('modalCategory').textContent = `${p.category.toUpperCase()} / ${p.color.toUpperCase()}`;
    $('modalName').textContent = p.name;
    $('modalDescription').textContent = p.description;
    $('modalPrice').textContent = money(p.price);
    $('modalSpecs').innerHTML = `
      <div class="spec-item"><small>Kategori</small><strong>${esc(p.category)}</strong></div>
      <div class="spec-item"><small>Ukuran</small><strong>${esc(p.sizes)}</strong></div>
      <div class="spec-item"><small>Warna</small><strong>${esc(p.color)}</strong></div>
      <div class="spec-item"><small>Material</small><strong>${esc(p.material)}</strong></div>
    `;
    openOverlay('productOverlay');
  }

  document.addEventListener('click', event => {
    const detail = event.target.closest('[data-detail]');
    if (detail) { showDetail(detail.dataset.detail); return; }

    const add = event.target.closest('[data-add]');
    if (add) { addToCart(add.dataset.add); return; }

    const filter = event.target.closest('[data-filter]');
    if (filter) { state.filter = filter.dataset.filter; renderProducts(); return; }

    const qty = event.target.closest('[data-qty]');
    if (qty) {
      const id = qty.dataset.qty;
      state.cart[id] = (Number(state.cart[id]) || 0) + Number(qty.dataset.delta);
      if (state.cart[id] <= 0) delete state.cart[id];
      saveCart();
      renderCart();
      return;
    }

    const remove = event.target.closest('[data-remove]');
    if (remove) {
      delete state.cart[remove.dataset.remove];
      saveCart();
      renderCart();
      return;
    }

    if (event.target.closest('#openCart')) { renderCart(); openOverlay('cartOverlay'); return; }
    if (event.target.closest('#clearCart')) { state.cart = {}; saveCart(); renderCart(); toast('Keranjang dikosongkan.'); return; }
    if (event.target.closest('#openCheckout')) {
      if (!cartRows().length) { toast('Keranjang masih kosong.'); return; }
      $('checkoutForm').hidden = false;
      $('orderSuccess').hidden = true;
      closeOverlay('cartOverlay');
      openOverlay('checkoutOverlay');
      return;
    }
    if (event.target.closest('#modalAdd')) {
      if (state.activeProduct) addToCart(state.activeProduct.id);
      closeOverlay('productOverlay');
      return;
    }

    if (event.target.closest('[data-close-cart]')) { closeOverlay('cartOverlay'); return; }
    if (event.target.closest('[data-close-product]')) { closeOverlay('productOverlay'); return; }
    if (event.target.closest('[data-close-checkout]')) { closeOverlay('checkoutOverlay'); return; }

    if (event.target.closest('#resetFilters')) {
      state.filter = 'Semua';
      state.query = '';
      $('searchInput').value = '';
      renderProducts();
      return;
    }

    if (event.target.closest('#finishOrder')) {
      closeOverlay('checkoutOverlay');
      $('checkoutForm').reset();
      $('checkoutForm').hidden = false;
      $('orderSuccess').hidden = true;
      document.getElementById('catalog').scrollIntoView({behavior:'smooth'});
      return;
    }

    if (event.target.classList.contains('overlay')) {
      closeOverlay(event.target.id);
      return;
    }

    const nav = event.target.closest('.nav-link');
    if (nav) {
      document.querySelectorAll('.nav-link').forEach(link => link.classList.toggle('active', link === nav));
      $('mainNav').classList.remove('open');
      $('menuToggle').setAttribute('aria-expanded', 'false');
    }

    if (event.target.closest('#menuToggle')) {
      const open = $('mainNav').classList.toggle('open');
      $('menuToggle').setAttribute('aria-expanded', String(open));
    }
  });

  $('searchInput').addEventListener('input', event => {
    state.query = event.target.value;
    renderProducts();
  });

  $('sortSelect').addEventListener('change', event => {
    state.sort = event.target.value;
    renderProducts();
  });

  $('checkoutForm').addEventListener('submit', event => {
    event.preventDefault();
    if (!cartRows().length) { toast('Keranjang masih kosong.'); return; }
    const name = $('customerName').value.trim() || 'Pelanggan';
    const items = cartCount();
    const total = cartTotal();
    $('successMessage').textContent = `Terima kasih, ${name}. Pesanan demo berisi ${items} item dengan total ${money(total)}. Tidak ada pembayaran yang diproses.`;
    $('checkoutForm').hidden = true;
    $('orderSuccess').hidden = false;
    state.cart = {};
    saveCart();
    renderCart();
  });

  document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
      ['productOverlay','cartOverlay','checkoutOverlay'].forEach(closeOverlay);
      $('mainNav').classList.remove('open');
      $('menuToggle').setAttribute('aria-expanded', 'false');
    }
    if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
      event.preventDefault();
      $('searchInput').focus();
      document.getElementById('catalog').scrollIntoView({behavior:'smooth'});
    }
  });

  renderProducts();
  renderCart();
})();