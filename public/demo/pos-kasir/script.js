(() => {
  'use strict';
  const STORAGE_KEY = 'ruma-pos-demo-v1';
  const TAX_RATE = 0;
  const products = [
    { id: 1, name: 'Kopi Susu Gula Aren', category: 'Kopi', price: 22000, image: 'kopi-susu.jpg', tag: 'Favorit', note: 'Es · Susu segar' },
    { id: 2, name: 'Americano', category: 'Kopi', price: 18000, image: 'americano.jpg', tag: 'Klasik', note: 'Hot / Iced' },
    { id: 3, name: 'Cappuccino', category: 'Kopi', price: 25000, image: 'cappuccino.jpg', tag: 'Signature', note: 'Espresso · Foam' },
    { id: 4, name: 'Matcha Latte', category: 'Non-kopi', price: 26000, image: 'matcha.jpg', tag: 'Best seller', note: 'Matcha · Susu' },
    { id: 5, name: 'Lemon Tea', category: 'Non-kopi', price: 16000, image: 'lemon-tea.jpg', tag: 'Segar', note: 'Teh · Lemon' },
    { id: 6, name: 'Butter Croissant', category: 'Makanan', price: 19000, image: 'croissant.jpg', tag: 'Fresh bake', note: 'Pastry · Butter' },
    { id: 7, name: 'Banana Bread', category: 'Makanan', price: 17000, image: 'banana-bread.jpg', tag: 'Homemade', note: 'Pisang · Walnut' },
    { id: 8, name: 'Cookies Cokelat', category: 'Snack', price: 14000, image: 'cookies.jpg', tag: 'Snack', note: 'Dark chocolate' },
    { id: 9, name: 'Chicken Sandwich', category: 'Makanan', price: 29000, image: 'sandwich.jpg', tag: 'Mengenyangkan', note: 'Ayam · Sayuran' },
    { id: 10, name: 'Air Mineral', category: 'Snack', price: 8000, image: 'air-mineral.jpg', tag: 'Dingin', note: '600 ml' }
  ];
  const $ = (id) => document.getElementById(id);
  const money = (amount) => 'Rp' + Math.round(Number(amount) || 0).toLocaleString('id-ID');
  const escapeHtml = (value) => String(value ?? '').replace(/[&<>"']/g, (char) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[char]));
  const productById = (id) => products.find((product) => product.id === Number(id));
  function loadSavedState() {
    try { const saved = JSON.parse(localStorage.getItem(STORAGE_KEY) || 'null'); if (saved && typeof saved === 'object') return saved; }
    catch (_) { /* Browser storage may be disabled; the demo still works in memory. */ }
    return {};
  }
  const saved = loadSavedState();
  const state = {
    category: 'Semua', search: '',
    cart: saved.cart && typeof saved.cart === 'object' ? saved.cart : {},
    payment: ['Tunai', 'QRIS', 'Debit'].includes(saved.payment) ? saved.payment : 'Tunai',
    customer: typeof saved.customer === 'string' ? saved.customer : '',
    cashReceived: '', cashAutoExact: true,
    transactions: Array.isArray(saved.transactions) ? saved.transactions : [],
    nextOrder: Number.isInteger(saved.nextOrder) && saved.nextOrder > 0 ? saved.nextOrder : 1
  };
  if (state.transactions.length >= state.nextOrder) state.nextOrder = state.transactions.length + 1;
  function persist() {
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify({ cart: state.cart, payment: state.payment, customer: state.customer, transactions: state.transactions, nextOrder: state.nextOrder })); }
    catch (_) { /* Ignore storage quota and privacy-mode errors. */ }
  }
  function toast(message) {
    const element = $('toast'); element.textContent = message; element.classList.add('show');
    clearTimeout(toast.timer); toast.timer = setTimeout(() => element.classList.remove('show'), 2400);
  }
  function cartRows() {
    return Object.entries(state.cart).map(([id, quantity]) => ({ product: productById(id), quantity: Number(quantity) })).filter((row) => row.product && row.quantity > 0);
  }
  function cartTotals() {
    const rows = cartRows(); const units = rows.reduce((sum, row) => sum + row.quantity, 0);
    const subtotal = rows.reduce((sum, row) => sum + row.product.price * row.quantity, 0);
    const tax = Math.round(subtotal * TAX_RATE); return { rows, units, subtotal, tax, total: subtotal + tax };
  }
  function imagePath(product) { return `assets/products/${product.image}`; }
  function renderCatalog() {
    const query = state.search.toLocaleLowerCase('id-ID').trim();
    const filtered = products.filter((product) => (state.category === 'Semua' || product.category === state.category) && `${product.name} ${product.category} ${product.note}`.toLocaleLowerCase('id-ID').includes(query));
    $('productGrid').innerHTML = filtered.length ? filtered.map((product) => `
      <button class="product-card" type="button" data-add-product="${product.id}" aria-label="Tambah ${escapeHtml(product.name)} ke pesanan">
        <span class="product-image-wrap"><img class="product-image" src="${imagePath(product)}" alt="${escapeHtml(product.name)}" loading="lazy"><span class="product-tag">${escapeHtml(product.tag)}</span></span>
        <span class="product-details"><span class="product-name">${escapeHtml(product.name)}</span><span class="product-meta">${escapeHtml(product.note)}</span><span class="product-bottom"><span class="product-price">${money(product.price)}</span><span class="add-product" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg></span></span></span>
      </button>`).join('') : '<div class="empty-products">Produk tidak ditemukan. Coba kata kunci lain.</div>';
    $('visibleProductCount').textContent = `${filtered.length} produk`;
    $('allProductCount').textContent = String(products.length);
    document.querySelectorAll('[data-category]').forEach((button) => button.classList.toggle('active', button.dataset.category === state.category));
  }
  function renderCart() {
    const totals = cartTotals();
    $('orderItems').innerHTML = totals.rows.length ? totals.rows.map(({ product, quantity }) => `
      <div class="cart-row"><div class="cart-thumb"><img src="${imagePath(product)}" alt=""></div>
        <div class="cart-info"><strong>${escapeHtml(product.name)}</strong><small>${money(product.price)} / item</small><div class="qty-control"><button type="button" data-qty="${product.id}" data-delta="-1" aria-label="Kurangi ${escapeHtml(product.name)}">−</button><span>${quantity}</span><button type="button" data-qty="${product.id}" data-delta="1" aria-label="Tambah ${escapeHtml(product.name)}">+</button></div></div>
        <div class="cart-trailing"><strong>${money(product.price * quantity)}</strong><button class="remove-item" type="button" data-remove="${product.id}">Hapus</button></div>
      </div>`).join('') : '<div class="empty-cart"><div class="empty-cart-art"><svg viewBox="0 0 64 64"><path d="M12 20h40l-4 34H16l-4-34Z"/><path d="M23 21v-6a9 9 0 0 1 18 0v6"/><path d="M23 32h18"/></svg></div><strong>Pesanan masih kosong</strong><span>Pilih produk dari katalog untuk mulai.</span></div>';
    $('subtotal').textContent = money(totals.subtotal);
    $('taxAmount').textContent = money(totals.tax);
    $('total').textContent = money(totals.total);
    $('cartNavCount').textContent = String(totals.units);
    $('orderNumber').textContent = `#ORD-${String(state.nextOrder).padStart(3, '0')}`;
    $('customerNameLabel').textContent = state.customer.trim() || 'Pelanggan umum';
    if (state.cashAutoExact) state.cashReceived = totals.total > 0 ? String(totals.total) : '';
    $('cashReceived').value = state.cashReceived;
    $('cashField').hidden = state.payment !== 'Tunai';
    document.querySelectorAll('[data-payment]').forEach((button) => button.classList.toggle('active', button.dataset.payment === state.payment));
    $('checkoutBtn').disabled = totals.units === 0;
    updateChange();
  }
  function updateChange() {
    const total = cartTotals().total;
    const received = Math.max(0, Number($('cashReceived').value) || 0);
    const change = received - total;
    $('changeAmount').textContent = change < 0 ? `Kurang ${money(Math.abs(change))}` : money(change);
    $('changeAmount').style.color = change < 0 ? '#b95b4f' : '#477956';
  }
  function todayKey(date = new Date()) { return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`; }
  function isToday(transaction) { return todayKey(new Date(transaction.timestamp)) === todayKey(); }
  function formatDate(timestamp) { return new Date(timestamp).toLocaleString('id-ID', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }); }
  function renderStats() {
    const today = state.transactions.filter(isToday);
    const salesToday = today.reduce((sum, transaction) => sum + transaction.total, 0);
    const unitsToday = today.reduce((sum, transaction) => sum + transaction.units, 0);
    $('salesMetric').textContent = money(salesToday);
    $('transactionMetric').textContent = String(today.length);
    $('itemMetric').textContent = String(unitsToday);
    renderHistory(); renderReports();
  }
  function renderHistory() {
    const transactions = [...state.transactions].reverse();
    $('historyCount').textContent = `${transactions.length} transaksi`;
    $('historyBody').innerHTML = transactions.length ? transactions.map((transaction) => `
      <tr><td><strong>${escapeHtml(transaction.id)}</strong></td><td>${escapeHtml(formatDate(transaction.timestamp))}</td><td>${escapeHtml(transaction.customer || 'Pelanggan umum')}</td><td>${transaction.units} item</td><td>${escapeHtml(transaction.payment)}</td><td><strong>${money(transaction.total)}</strong></td><td><span class="status-pill">Berhasil</span></td></tr>`).join('') : '<tr><td class="empty-table" colspan="7">Belum ada transaksi. Transaksi yang selesai akan muncul di sini.</td></tr>';
  }
  function renderReports() {
    const transactions = state.transactions;
    const sales = transactions.reduce((sum, transaction) => sum + transaction.total, 0);
    const units = transactions.reduce((sum, transaction) => sum + transaction.units, 0);
    $('reportSales').textContent = money(sales);
    $('reportCount').textContent = String(transactions.length);
    $('reportUnits').textContent = String(units);
    $('reportAverage').textContent = money(transactions.length ? Math.round(sales / transactions.length) : 0);
    const best = new Map();
    transactions.forEach((transaction) => transaction.items.forEach((item) => {
      const previous = best.get(item.productId) || { productId: item.productId, quantity: 0, revenue: 0 };
      previous.quantity += item.quantity; previous.revenue += item.price * item.quantity; best.set(item.productId, previous);
    }));
    const ranking = [...best.values()].sort((a, b) => b.quantity - a.quantity).slice(0, 5);
    const maxQuantity = ranking.length ? ranking[0].quantity : 1;
    $('bestSellers').innerHTML = ranking.length ? ranking.map((item) => {
      const product = productById(item.productId);
      if (!product) return '';
      return `<div class="best-seller-row"><div class="best-seller-thumb"><img src="${imagePath(product)}" alt=""></div><div class="best-seller-info"><strong>${escapeHtml(product.name)}</strong><small>${money(item.revenue)} omzet</small><div class="best-seller-bar"><span style="width:${Math.max(5, item.quantity / maxQuantity * 100)}%"></span></div></div><span class="best-seller-count">${item.quantity} unit</span></div>`;
    }).join('') : '<div class="empty-report">Data produk terlaris akan muncul setelah transaksi pertama.</div>';
    const paymentCounts = ['Tunai', 'QRIS', 'Debit'].map((method) => ({ method, count: transactions.filter((transaction) => transaction.payment === method).length }));
    $('paymentReport').innerHTML = paymentCounts.map((item) => `<div class="payment-report-row"><div class="payment-report-top"><span>${item.method}</span><strong>${item.count} transaksi · ${transactions.length ? Math.round(item.count / transactions.length * 100) : 0}%</strong></div><div class="payment-bar"><span style="width:${transactions.length ? item.count / transactions.length * 100 : 0}%"></span></div></div>`).join('') + '<div class="payment-report-note">Komposisi dihitung dari seluruh transaksi tersimpan di browser ini.</div>';
  }
  function switchView(name) {
    const valid = ['kasir', 'transaksi', 'laporan'].includes(name) ? name : 'kasir';
    document.querySelectorAll('.view').forEach((view) => view.classList.toggle('active', view.id === `view-${valid}`));
    document.querySelectorAll('[data-view]').forEach((button) => button.classList.toggle('active', button.dataset.view === valid));
    $('pageTitle').textContent = valid === 'kasir' ? 'Kasir' : valid === 'transaksi' ? 'Transaksi' : 'Laporan';
    if (valid === 'transaksi') renderHistory();
    if (valid === 'laporan') renderReports();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
  function openModal(id) { $(id).classList.add('open'); $(id).setAttribute('aria-hidden', 'false'); }
  function closeModal(id) { $(id).classList.remove('open'); $(id).setAttribute('aria-hidden', 'true'); }
  function showReceipt(transaction) {
    $('receiptTitle').textContent = 'Pembayaran berhasil';
    $('receiptSubtitle').textContent = `${transaction.id} berhasil disimpan di demo.`;
    $('receiptId').textContent = transaction.id;
    $('receiptTime').textContent = formatDate(transaction.timestamp);
    $('receiptLines').innerHTML = transaction.items.map((item) => `<div class="receipt-line"><span>${escapeHtml(item.name)} × ${item.quantity}</span><strong>${money(item.price * item.quantity)}</strong></div>`).join('');
    $('receiptTotal').textContent = money(transaction.total);
    $('receiptPayment').textContent = transaction.payment;
    $('receiptCash').textContent = money(transaction.cashReceived || 0);
    $('receiptChange').textContent = money(transaction.change || 0);
    $('receiptChangeRow').hidden = transaction.payment !== 'Tunai';
    openModal('receiptModal');
  }
  function processCheckout() {
    const totals = cartTotals();
    if (!totals.units) { toast('Tambahkan produk sebelum memproses pembayaran.'); return; }
    const received = Math.max(0, Number($('cashReceived').value) || 0);
    if (state.payment === 'Tunai' && received < totals.total) {
      toast(`Uang diterima kurang ${money(totals.total - received)}.`); $('cashReceived').focus(); return;
    }
    const transaction = {
      id: `TRX-${String(state.nextOrder).padStart(3, '0')}`,
      orderNumber: `ORD-${String(state.nextOrder).padStart(3, '0')}`,
      timestamp: Date.now(), customer: state.customer.trim() || 'Pelanggan umum', payment: state.payment,
      items: totals.rows.map(({ product, quantity }) => ({ productId: product.id, name: product.name, price: product.price, quantity })),
      units: totals.units, subtotal: totals.subtotal, tax: totals.tax, total: totals.total,
      cashReceived: state.payment === 'Tunai' ? received : 0,
      change: state.payment === 'Tunai' ? received - totals.total : 0
    };
    state.transactions.push(transaction); state.nextOrder += 1; state.cart = {}; state.customer = '';
    state.payment = 'Tunai'; state.cashReceived = ''; state.cashAutoExact = true;
    persist(); renderCart(); renderStats(); renderCatalog(); showReceipt(transaction);
  }
  document.addEventListener('click', (event) => {
    const addButton = event.target.closest('[data-add-product]');
    if (addButton) {
      const id = addButton.dataset.addProduct;
      state.cart[id] = (Number(state.cart[id]) || 0) + 1;
      renderCart(); persist(); toast('Produk ditambahkan ke pesanan.'); return;
    }
    const qtyButton = event.target.closest('[data-qty]');
    if (qtyButton) {
      const id = qtyButton.dataset.qty;
      state.cart[id] = (Number(state.cart[id]) || 0) + Number(qtyButton.dataset.delta);
      if (state.cart[id] <= 0) delete state.cart[id];
      renderCart(); persist(); return;
    }
    const removeButton = event.target.closest('[data-remove]');
    if (removeButton) { delete state.cart[removeButton.dataset.remove]; renderCart(); persist(); toast('Produk dihapus dari pesanan.'); return; }
    const categoryButton = event.target.closest('[data-category]');
    if (categoryButton) { state.category = categoryButton.dataset.category; renderCatalog(); return; }
    const paymentButton = event.target.closest('[data-payment]');
    if (paymentButton) { state.payment = paymentButton.dataset.payment; renderCart(); persist(); return; }
    const viewButton = event.target.closest('[data-view]');
    if (viewButton) { switchView(viewButton.dataset.view); return; }
    const cashButton = event.target.closest('[data-cash]');
    if (cashButton) {
      if (cashButton.dataset.cash === 'exact') { state.cashAutoExact = true; state.cashReceived = String(cartTotals().total || ''); }
      else { state.cashAutoExact = false; state.cashReceived = cashButton.dataset.cash; }
      $('cashReceived').value = state.cashReceived; updateChange(); return;
    }
  });
  $('searchInput').addEventListener('input', (event) => { state.search = event.target.value; renderCatalog(); });
  $('cashReceived').addEventListener('input', (event) => { state.cashAutoExact = false; state.cashReceived = event.target.value; updateChange(); });
  $('checkoutBtn').addEventListener('click', processCheckout);
  $('clearCartBtn').addEventListener('click', () => {
    if (!cartRows().length) { toast('Pesanan sudah kosong.'); return; }
    if (window.confirm('Kosongkan semua produk dari pesanan ini?')) { state.cart = {}; state.cashAutoExact = true; state.cashReceived = ''; renderCart(); persist(); toast('Pesanan dikosongkan.'); }
  });
  $('editCustomerBtn').addEventListener('click', () => { $('customerInput').value = state.customer; openModal('customerModal'); $('customerInput').focus(); });
  $('saveCustomerBtn').addEventListener('click', () => {
    state.customer = $('customerInput').value.trim().slice(0, 60); renderCart(); persist(); closeModal('customerModal'); toast(state.customer ? 'Nama pelanggan diperbarui.' : 'Pelanggan diatur sebagai pelanggan umum.');
  });
  $('closeCustomerBtn').addEventListener('click', () => closeModal('customerModal'));
  $('cancelCustomerBtn').addEventListener('click', () => closeModal('customerModal'));
  $('closeReceiptBtn').addEventListener('click', () => closeModal('receiptModal'));
  $('finishReceiptBtn').addEventListener('click', () => { closeModal('receiptModal'); switchView('kasir'); toast('Transaksi demo tersimpan.'); });
  $('printReceiptBtn').addEventListener('click', () => window.print());
  ['receiptModal', 'customerModal'].forEach((id) => $(id).addEventListener('click', (event) => { if (event.target.id === id) closeModal(id); }));
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') { closeModal('receiptModal'); closeModal('customerModal'); }
    if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') { event.preventDefault(); switchView('kasir'); $('searchInput').focus(); }
  });

  $('todayLabel').textContent = new Date().toLocaleDateString('id-ID', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' });
  renderCatalog(); renderCart(); renderStats();
})();
