(() => {
  'use strict';
  const products = [
    {id:1,name:'Kopi Susu Gula Aren',category:'Kopi',price:22000,image:'kopi-susu.jpg',tag:'Favorit',note:'Es kopi dengan susu segar dan gula aren.',description:'Perpaduan espresso, susu segar, dan gula aren dengan rasa creamy dan manis seimbang. Tersedia dingin untuk menemani aktivitas harian.'},
    {id:2,name:'Americano',category:'Kopi',price:18000,image:'americano.jpg',tag:'Klasik',note:'Kopi hitam dengan karakter yang bersih.',description:'Espresso dan air dengan karakter kopi yang ringan, bersih, dan mudah dinikmati. Pilihan sederhana untuk pencinta kopi hitam.'},
    {id:3,name:'Cappuccino',category:'Kopi',price:25000,image:'cappuccino.jpg',tag:'Signature',note:'Espresso dengan foam susu lembut.',description:'Espresso berpadu dengan susu steamed dan foam lembut. Disajikan dengan tekstur seimbang dan aroma kopi yang khas.'},
    {id:4,name:'Matcha Latte',category:'Non-kopi',price:26000,image:'matcha.jpg',tag:'Best seller',note:'Matcha dan susu dengan rasa lembut.',description:'Matcha dengan aroma teh hijau dan susu yang lembut. Cocok untuk pilihan minuman non-kopi dengan rasa khas.'},
    {id:5,name:'Lemon Tea',category:'Non-kopi',price:16000,image:'lemon-tea.jpg',tag:'Segar',note:'Teh lemon dingin yang menyegarkan.',description:'Teh dengan sentuhan lemon dan es. Rasa segar yang cocok dinikmati siang hari.'},
    {id:6,name:'Butter Croissant',category:'Makanan',price:19000,image:'croissant.jpg',tag:'Fresh bake',note:'Pastry renyah dengan aroma butter.',description:'Croissant berlapis dengan bagian luar keemasan dan bagian dalam lembut. Cocok dipasangkan dengan kopi favorit.'},
    {id:7,name:'Banana Bread',category:'Makanan',price:17000,image:'banana-bread.jpg',tag:'Homemade',note:'Roti pisang lembut untuk teman minum.',description:'Banana bread dengan tekstur lembut dan rasa pisang yang nyaman. Pilihan camilan untuk waktu santai.'},
    {id:8,name:'Cookies Cokelat',category:'Snack',price:14000,image:'cookies.jpg',tag:'Snack',note:'Cookies cokelat dengan potongan cokelat.',description:'Cookies cokelat dengan tekstur padat dan potongan cokelat. Cocok sebagai camilan atau teman minum.'},
    {id:9,name:'Chicken Sandwich',category:'Makanan',price:29000,image:'sandwich.jpg',tag:'Mengenyangkan',note:'Sandwich ayam dengan sayuran segar.',description:'Roti lembut berisi ayam panggang, selada, tomat, dan saus. Menu praktis untuk makan ringan.'},
    {id:10,name:'Air Mineral',category:'Snack',price:8000,image:'air-mineral.jpg',tag:'Dingin',note:'Air mineral kemasan 600 ml.',description:'Air mineral kemasan untuk menemani aktivitas sehari-hari. Disajikan dingin sesuai ketersediaan.'}
  ];
  const $ = id => document.getElementById(id);
  const money = value => 'Rp' + Math.round(Number(value) || 0).toLocaleString('id-ID');
  const escapeHtml = value => String(value ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
  const state = {category:'Semua',search:'',product:null};
  let toastTimer;
  function toast(message){
    const el=$('toast'); el.textContent=message; el.classList.add('show');
    clearTimeout(toastTimer); toastTimer=setTimeout(()=>el.classList.remove('show'),2400);
  }
  function renderProducts(){
    const query=state.search.toLocaleLowerCase('id-ID').trim();
    const shown=products.filter(p=>(state.category==='Semua'||p.category===state.category)&&`${p.name} ${p.category} ${p.note}`.toLocaleLowerCase('id-ID').includes(query));
    $('productGrid').innerHTML=shown.map(p=>`
      <article class="product-card">
        <div class="product-photo"><img src="assets/products/${p.image}" alt="${escapeHtml(p.name)}" loading="lazy"><span class="tag">${escapeHtml(p.tag)}</span></div>
        <div class="product-info"><span class="product-category">${escapeHtml(p.category)}</span><h3>${escapeHtml(p.name)}</h3><p>${escapeHtml(p.note)}</p>
          <div class="product-bottom"><strong class="price">${money(p.price)}</strong><button class="view-product" type="button" data-product-id="${p.id}" aria-label="Lihat detail ${escapeHtml(p.name)}">↗</button></div>
        </div>
      </article>`).join('');
    $('productCount').textContent=String(shown.length);
    $('emptyState').hidden=shown.length!==0;
    $('productGrid').hidden=shown.length===0;
    document.querySelectorAll('[data-category]').forEach(b=>b.classList.toggle('active',b.dataset.category===state.category));
  }
  function openModal(id){$(id).classList.add('open');$(id).setAttribute('aria-hidden','false');document.body.classList.add('modal-open');}
  function closeModal(id){$(id).classList.remove('open');$(id).setAttribute('aria-hidden','true');if(!document.querySelector('.backdrop.open'))document.body.classList.remove('modal-open');}
  function showProduct(id){
    const p=products.find(item=>item.id===Number(id)); if(!p)return;
    state.product=p;
    $('modalProductImage').src='assets/products/'+p.image;
    $('modalProductImage').alt=p.name;
    $('modalProductCategory').textContent=p.category+' · '+p.tag;
    $('modalProductName').textContent=p.name;
    $('modalProductDescription').textContent=p.description;
    $('modalProductPrice').textContent=money(p.price);
    openModal('productModal');
  }
  function openInquiry(product){
    state.product=product||null;
    $('inquiryProduct').value=product?product.name:'Pertanyaan umum';
    $('inquiryMessage').value=product?`Halo, saya ingin mengetahui informasi lebih lanjut tentang ${product.name}.`:'Halo, saya ingin mengetahui informasi lebih lanjut tentang katalog produk.';
    $('inquiryResult').hidden=true;
    openModal('inquiryModal');
    setTimeout(()=>$('inquiryName').focus(),50);
  }
  document.addEventListener('click',event=>{
    const productButton=event.target.closest('[data-product-id]');
    if(productButton){showProduct(productButton.dataset.productId);return;}
    const category=event.target.closest('[data-category]');
    if(category){state.category=category.dataset.category;renderProducts();return;}
    if(event.target.closest('[data-open-inquiry]')){closeModal('productModal');openInquiry(null);return;}
    if(event.target.closest('[data-close-modal]')){closeModal('productModal');return;}
    if(event.target.closest('[data-close-inquiry]')){closeModal('inquiryModal');return;}
    if(event.target.closest('#askAboutProduct')){const p=state.product;closeModal('productModal');openInquiry(p);return;}
    if(event.target.closest('#resetFilters')){state.category='Semua';state.search='';$('searchInput').value='';renderProducts();return;}
    if(event.target.closest('#copyMessage')){copyMessage();return;}
    if(event.target.closest('#menuToggle')){
      const nav=$('mainNav');const open=nav.classList.toggle('open');
      $('menuToggle').setAttribute('aria-expanded',String(open));return;
    }
    if(event.target.classList.contains('backdrop'))closeModal(event.target.id);
    const navLink=event.target.closest('.main-nav a');
    if(navLink){$('mainNav').classList.remove('open');$('menuToggle').setAttribute('aria-expanded','false');document.querySelectorAll('.main-nav a').forEach(a=>a.classList.toggle('active',a===navLink));}
  });
  $('searchInput').addEventListener('input',event=>{state.search=event.target.value;renderProducts();});
  $('inquiryForm').addEventListener('submit',event=>{
    event.preventDefault();
    const name=$('inquiryName').value.trim();
    const product=$('inquiryProduct').value;
    const message=$('inquiryMessage').value.trim();
    const generated=`Nama: ${name}\nProduk: ${product}\nPesan: ${message}`;
    $('generatedMessage').textContent=generated;
    $('inquiryResult').hidden=false;
    toast('Pesan demo berhasil dibuat.');
  });
  async function copyMessage(){
    const text=$('generatedMessage').textContent;
    if(!text){toast('Buat pesan terlebih dahulu.');return;}
    try{await navigator.clipboard.writeText(text);toast('Pesan disalin.');}
    catch(_){const temp=document.createElement('textarea');temp.value=text;document.body.appendChild(temp);temp.select();const ok=document.execCommand('copy');temp.remove();toast(ok?'Pesan disalin.':'Salin pesan secara manual.');}
  }
  document.addEventListener('keydown',event=>{
    if(event.key==='Escape'){closeModal('productModal');closeModal('inquiryModal');}
    if((event.ctrlKey||event.metaKey)&&event.key.toLowerCase()==='k'){event.preventDefault();$('searchInput').focus();$('katalog').scrollIntoView({behavior:'smooth'});}
  });
  renderProducts();
})();