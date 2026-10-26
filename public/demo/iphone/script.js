(() => {
  'use strict';
  const products = [
    {id:1,name:'iPhone 16 Pro',storage:'256 GB',series:'Pro',color:'Natural Titanium',price:19999000,image:'iphone-pro-graphite.jpg',label:'Pilihan utama',display:'Layar Super Retina XDR',camera:'Sistem kamera Pro',description:'Pilihan premium dengan desain titanium, kamera serbaguna, dan performa untuk aktivitas kreatif maupun harian.'},
    {id:2,name:'iPhone 16',storage:'128 GB',series:'Reguler',color:'Ultramarine',price:14999000,image:'iphone-blue.jpg',label:'Warna pilihan',display:'Layar Super Retina XDR',camera:'Kamera ganda',description:'iPhone serbaguna dengan desain modern, kamera yang praktis, dan performa yang nyaman untuk kebutuhan sehari-hari.'},
    {id:3,name:'iPhone 16',storage:'128 GB',series:'Reguler',color:'Pink',price:14999000,image:'iphone-pink.jpg',label:'Soft pink',display:'Layar Super Retina XDR',camera:'Kamera ganda',description:'Pilihan iPhone dengan warna lembut, bentuk minimalis, dan fitur yang mendukung aktivitas sehari-hari.'},
    {id:4,name:'iPhone 15 Pro',storage:'256 GB',series:'Pro',color:'Black Titanium',price:17499000,image:'iphone-dark.jpg',label:'Seri Pro',display:'Layar Super Retina XDR',camera:'Sistem kamera Pro',description:'Seri Pro dengan tampilan tegas, kamera fleksibel, dan desain yang berfokus pada detail.'},
    {id:5,name:'iPhone 16',storage:'128 GB',series:'Reguler',color:'Green',price:14999000,image:'iphone-green.jpg',label:'Natural green',display:'Layar Super Retina XDR',camera:'Kamera ganda',description:'Warna hijau lembut dengan tampilan bersih. Pilihan untuk pengguna yang mengutamakan keseimbangan desain dan fungsi.'},
    {id:6,name:'iPhone Pro Collection',storage:'Pilihan kapasitas',series:'Pro',color:'Titanium',price:22999000,image:'hero-iphone.jpg',label:'Koleksi premium',display:'Layar premium',camera:'Kamera tingkat lanjut',description:'Koleksi premium FORME untuk pelanggan yang mencari pengalaman iPhone dengan desain dan kemampuan tingkat lanjut.'}
  ];
  const $ = id => document.getElementById(id);
  const money = amount => 'Rp' + Math.round(Number(amount) || 0).toLocaleString('id-ID');
  const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
  const STORAGE_KEY = 'forme-iphone-demo-cart-v1';
  function readCart(){try{const value=JSON.parse(localStorage.getItem(STORAGE_KEY)||'{}');return value&&typeof value==='object'?value:{}}catch(_){return {}}}
  const state = {filter:'Semua',query:'',sort:'featured',cart:readCart(),activeProduct:null};
  let toastTimer;
  function saveCart(){try{localStorage.setItem(STORAGE_KEY,JSON.stringify(state.cart))}catch(_){}}
  function toast(message){const el=$('toast');el.textContent=message;el.classList.add('show');clearTimeout(toastTimer);toastTimer=setTimeout(()=>el.classList.remove('show'),2200)}
  function visibleProducts(){
    let list=products.filter(p=>(state.filter==='Semua'||p.series===state.filter)&&`${p.name} ${p.storage} ${p.series} ${p.color}`.toLocaleLowerCase('id-ID').includes(state.query.toLocaleLowerCase('id-ID').trim()));
    if(state.sort==='price-low')list.sort((a,b)=>a.price-b.price);
    else if(state.sort==='price-high')list.sort((a,b)=>b.price-a.price);
    else if(state.sort==='name')list.sort((a,b)=>a.name.localeCompare(b.name,'id'));
    return list;
  }
  function renderProducts(){
    const list=visibleProducts();
    $('productGrid').innerHTML=list.map(p=>`
      <article class="product-card">
        <button class="product-photo" type="button" data-detail="${p.id}" aria-label="Lihat detail ${esc(p.name)}">
          <img src="assets/products/${p.image}" alt="${esc(p.name)} ${esc(p.color)}" loading="lazy">
          <span class="product-label">${esc(p.label)}</span>
        </button>
        <div class="product-info"><span class="product-series">${esc(p.series)} series · ${esc(p.color)}</span><h3>${esc(p.name)}</h3><p class="product-spec">${esc(p.storage)} · ${esc(p.display)}</p>
          <div class="product-bottom"><strong class="product-price">${money(p.price)}</strong><button class="add-button" type="button" data-add="${p.id}">Tambah <span>＋</span></button></div>
        </div>
      </article>`).join('');
    $('productCount').textContent=String(list.length).padStart(2,'0');
    $('emptyState').hidden=list.length>0;
    $('productGrid').hidden=list.length===0;
    document.querySelectorAll('[data-filter]').forEach(b=>b.classList.toggle('active',b.dataset.filter===state.filter));
  }
  function cartEntries(){return Object.entries(state.cart).map(([id,qty])=>({product:products.find(p=>p.id===Number(id)),qty:Number(qty)})).filter(row=>row.product&&row.qty>0)}
  function cartTotal(){return cartEntries().reduce((sum,row)=>sum+row.product.price*row.qty,0)}
  function renderCart(){
    const rows=cartEntries(),count=rows.reduce((sum,row)=>sum+row.qty,0),total=cartTotal();
    $('cartCount').textContent=String(count);
    $('drawerCount').textContent=`(${count})`;
    $('cartSubtotal').textContent=money(total);
    $('checkoutTotal').textContent=money(total);
    $('cartItems').innerHTML=rows.map(({product:p,qty})=>`
      <div class="cart-row"><img src="assets/products/${p.image}" alt="${esc(p.name)}">
        <div><h3>${esc(p.name)}</h3><small>${esc(p.storage)} · ${esc(p.color)}</small><strong class="row-price">${money(p.price*qty)}</strong>
          <div class="quantity-controls"><button type="button" data-qty="${p.id}" data-delta="-1" aria-label="Kurangi">−</button><span>${qty}</span><button type="button" data-qty="${p.id}" data-delta="1" aria-label="Tambah">＋</button><button class="remove-link" type="button" data-remove="${p.id}">Hapus</button></div>
        </div>
      </div>`).join('');
    $('cartEmpty').classList.toggle('show',rows.length===0);
    $('drawerBottom').hidden=rows.length===0;
    $('openCheckout').disabled=rows.length===0;
  }
  function openOverlay(id){$(id).classList.add('open');$(id).setAttribute('aria-hidden','false');document.body.classList.add('locked')}
  function closeOverlay(id){$(id).classList.remove('open');$(id).setAttribute('aria-hidden','true');if(!document.querySelector('.overlay.open'))document.body.classList.remove('locked')}
  function addToCart(id){const p=products.find(item=>item.id===Number(id));if(!p)return;state.cart[p.id]=(Number(state.cart[p.id])||0)+1;saveCart();renderCart();toast(`${p.name} ditambahkan ke tas.`)}
  function showDetail(id){
    const p=products.find(item=>item.id===Number(id));if(!p)return;state.activeProduct=p;
    $('modalImage').src='assets/products/'+p.image;$('modalImage').alt=p.name+' '+p.color;
    $('modalSeries').textContent=p.series+' SERIES · '+p.color.toUpperCase();
    $('modalName').textContent=p.name;$('modalDescription').textContent=p.description;$('modalPrice').textContent=money(p.price);
    $('modalSpecs').innerHTML=`<div class="spec-item"><small>Kapasitas</small><strong>${esc(p.storage)}</strong></div><div class="spec-item"><small>Warna</small><strong>${esc(p.color)}</strong></div><div class="spec-item"><small>Layar</small><strong>${esc(p.display)}</strong></div><div class="spec-item"><small>Kamera</small><strong>${esc(p.camera)}</strong></div>`;
    openOverlay('productOverlay');
  }
  document.addEventListener('click',event=>{
    const detail=event.target.closest('[data-detail]');if(detail){showDetail(detail.dataset.detail);return}
    const add=event.target.closest('[data-add]');if(add){addToCart(add.dataset.add);return}
    const filter=event.target.closest('[data-filter]');if(filter){state.filter=filter.dataset.filter;renderProducts();return}
    const qty=event.target.closest('[data-qty]');if(qty){const id=qty.dataset.qty;state.cart[id]=(Number(state.cart[id])||0)+Number(qty.dataset.delta);if(state.cart[id]<=0)delete state.cart[id];saveCart();renderCart();return}
    const remove=event.target.closest('[data-remove]');if(remove){delete state.cart[remove.dataset.remove];saveCart();renderCart();return}
    if(event.target.closest('#openCart')){renderCart();openOverlay('cartOverlay');return}
    if(event.target.closest('[data-close-cart]')){closeOverlay('cartOverlay');return}
    if(event.target.closest('[data-close-product]')){closeOverlay('productOverlay');return}
    if(event.target.closest('[data-close-checkout]')){closeOverlay('checkoutOverlay');return}
    if(event.target.closest('#clearCart')){state.cart={};saveCart();renderCart();toast('Tas belanja dikosongkan.');return}
    if(event.target.closest('#modalAdd')){if(state.activeProduct)addToCart(state.activeProduct.id);closeOverlay('productOverlay');return}
    if(event.target.closest('#openCheckout')){
      if(!cartEntries().length){toast('Tambahkan produk terlebih dahulu.');return}
      $('checkoutForm').hidden=false;$('orderSuccess').hidden=true;closeOverlay('cartOverlay');renderCart();openOverlay('checkoutOverlay');return
    }
    if(event.target.closest('#resetFilters')){state.filter='Semua';state.query='';$('searchInput').value='';renderProducts();return}
    if(event.target.closest('#finishOrder')){closeOverlay('checkoutOverlay');$('checkoutForm').reset();$('checkoutForm').hidden=false;$('orderSuccess').hidden=true;renderCart();document.getElementById('collection').scrollIntoView({behavior:'smooth'});return}
    if(event.target.classList.contains('overlay')){closeOverlay(event.target.id);return}
    const nav=event.target.closest('.nav-link');if(nav){document.querySelectorAll('.nav-link').forEach(a=>a.classList.toggle('active',a===nav));$('mainNav').classList.remove('open');$('menuToggle').setAttribute('aria-expanded','false')}
    if(event.target.closest('#menuToggle')){const open=$('mainNav').classList.toggle('open');$('menuToggle').setAttribute('aria-expanded',String(open))}
  });
  $('searchInput').addEventListener('input',event=>{state.query=event.target.value;renderProducts();if(location.hash!=='#collection')history.replaceState(null,'','#collection')});
  $('sortSelect').addEventListener('change',event=>{state.sort=event.target.value;renderProducts()});
  $('checkoutForm').addEventListener('submit',event=>{
    event.preventDefault();if(!cartEntries().length){toast('Tas belanja masih kosong.');return}
    const name=$('customerName').value.trim(),total=cartTotal(),items=cartEntries().reduce((sum,row)=>sum+row.qty,0);
    $('successMessage').textContent=`Terima kasih, ${name}. Pesanan demo berisi ${items} unit dengan total ${money(total)}. Tidak ada pembayaran yang diproses.`;
    $('checkoutForm').hidden=true;$('orderSuccess').hidden=false;
    state.cart={};saveCart();renderCart();
  });
  document.addEventListener('keydown',event=>{
    if(event.key==='Escape'){['cartOverlay','productOverlay','checkoutOverlay'].forEach(closeOverlay);$('mainNav').classList.remove('open');$('menuToggle').setAttribute('aria-expanded','false')}
    if((event.ctrlKey||event.metaKey)&&event.key.toLowerCase()==='k'){event.preventDefault();$('searchInput').focus();document.getElementById('collection').scrollIntoView({behavior:'smooth'})}
  });
  renderProducts();renderCart();
})();