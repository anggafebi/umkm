
const products=[
{id:1,name:"Portugal Home Jersey",category:"national",image:"portugal-home.png",price:329000,badge:"POPULAR"},
{id:2,name:"Portugal Away Jersey",category:"national",image:"portugal-away.jpg",price:319000,badge:""},
{id:3,name:"Chelsea Home Jersey",category:"club",image:"celsi-home.png",price:299000,badge:"BESTSELLER"},
{id:4,name:"Chelsea Away Jersey",category:"club",image:"celsi-away.png",price:299000,badge:""},
{id:5,name:"Blue Lock Home Edition",category:"special",image:"isagi-home.png",price:349000,badge:"SPECIAL"},
{id:6,name:"Blue Lock Away Edition",category:"special",image:"isagi-away.png",price:349000,badge:"SPECIAL"}
];
const rupiah=n=>new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",maximumFractionDigits:0}).format(n);
const $=id=>document.getElementById(id);
let cart=[];try{cart=JSON.parse(localStorage.getItem("goalgear_demo_cart")||"[]");if(!Array.isArray(cart))cart=[]}catch{cart=[]}
let filter="all",query="",selectedSize="M",selectedProduct=null;
const escapeHTML=s=>String(s).replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c]));
function notify(message){$("toast").textContent=message;$("toast").classList.add("show");clearTimeout(window.toastTimer);window.toastTimer=setTimeout(()=>$("toast").classList.remove("show"),2600)}
function renderProducts(){
const shown=products.filter(p=>(filter==="all"||p.category===filter)&&p.name.toLowerCase().includes(query));
$("noResults").hidden=shown.length>0;
$("products").innerHTML=shown.map(p=>`<article class="product"><div class="photo"><img src="assets/${p.image}" alt="${escapeHTML(p.name)}" loading="lazy">${p.badge?`<span class="tag">${p.badge}</span>`:""}</div><div class="product-info"><h3>${escapeHTML(p.name)}</h3><b>${rupiah(p.price)}</b></div><p class="product-category">${{club:"Club Kits",national:"National Teams",special:"Special Edition"}[p.category]}</p><div class="actions"><button data-detail="${p.id}">Lihat detail</button><button data-add="${p.id}">+ Keranjang</button></div></article>`).join("");
}
function save(){localStorage.setItem("goalgear_demo_cart",JSON.stringify(cart));renderCart()}
function add(id,size="M"){const p=products.find(p=>p.id===id);if(!p)return;const item=cart.find(i=>i.id===id&&i.size===size);if(item)item.qty++;else cart.push({id,size,qty:1});save();notify(`${p.name} (${size}) ditambahkan`)}
function total(){return cart.reduce((n,i)=>n+(products.find(p=>p.id===i.id)?.price||0)*i.qty,0)}
function renderCart(){
$("cartCount").textContent=cart.reduce((n,i)=>n+i.qty,0);$("subtotal").textContent=rupiah(total());
$("cartItems").innerHTML=cart.length?cart.map((i,index)=>{const p=products.find(p=>p.id===i.id);if(!p)return"";return `<div class="cart-row"><img src="assets/${p.image}" alt=""><div><h4>${escapeHTML(p.name)}</h4><small>Ukuran ${i.size} · ${rupiah(p.price)}</small><div class="qty"><button data-qty="${index}" data-delta="-1" aria-label="Kurangi">−</button><span>${i.qty}</span><button data-qty="${index}" data-delta="1" aria-label="Tambah">+</button></div></div><button class="remove" data-remove="${index}">Hapus</button></div>`}).join(""):"<p>Keranjang masih kosong. Yuk pilih jersey favoritmu.</p>";
$("checkoutOpen").disabled=cart.length===0;
}
function cartVisible(open){$("cart").classList.toggle("open",open);$("cart").setAttribute("aria-hidden",String(!open));$("shade").hidden=!open;document.body.style.overflow=open?"hidden":""}
function openDetail(id){selectedProduct=products.find(p=>p.id===id);selectedSize="M";if(!selectedProduct)return;const p=selectedProduct;
$("detailBody").innerHTML=`<div class="detail-grid"><div class="detail-photo"><img src="assets/${p.image}" alt="${escapeHTML(p.name)}"></div><div class="detail-copy"><span class="eyebrow">GOALGEAR COLLECTION</span><h2>${escapeHTML(p.name)}</h2><strong>${rupiah(p.price)}</strong><p>Jersey untuk melengkapi koleksi match-day kamu. Pilih ukuran untuk mencoba simulasi pembelian.</p><p><b>Pilih ukuran</b></p><div class="sizes">${["S","M","L","XL"].map(s=>`<button data-size="${s}" class="${s==="M"?"active":""}">${s}</button>`).join("")}</div><button class="button full" id="detailAdd">Tambah ke keranjang →</button><p>Produk dan harga untuk keperluan demo.</p></div></div>`;
$("detail").showModal()}
function checkoutView(){cartVisible(false);if(!cart.length)return;const ship=15000;const subtotal=total();
$("checkoutBody").innerHTML=`<div class="checkout-content"><span class="eyebrow">SIMULASI TRANSAKSI</span><h2>Checkout</h2><p>Form ini tidak mengirim data ke server dan tidak memproses pembayaran.</p><form id="checkoutForm"><label>Nama penerima<input name="name" required maxlength="80" placeholder="Nama lengkap" autocomplete="off"></label><label>Kota tujuan<input name="city" required maxlength="80" placeholder="Contoh: Madiun" autocomplete="off"></label><label>Metode pembayaran<select name="method"><option>Transfer bank (simulasi)</option><option>Bayar di tempat (simulasi)</option></select></label><div class="receipt"><div><span>Subtotal (${cart.reduce((n,i)=>n+i.qty,0)} item)</span><b>${rupiah(subtotal)}</b></div><div><span>Ongkir simulasi</span><b>${rupiah(ship)}</b></div><hr><div><strong>Total</strong><strong>${rupiah(subtotal+ship)}</strong></div></div><button class="button full" type="submit">Buat pesanan simulasi →</button></form></div>`;
$("checkout").showModal()}
$("filters").addEventListener("click",e=>{const b=e.target.closest("[data-filter]");if(!b)return;filter=b.dataset.filter;document.querySelectorAll("[data-filter]").forEach(x=>x.classList.toggle("active",x===b));renderProducts()});
$("search").addEventListener("input",e=>{query=e.target.value.trim().toLowerCase();renderProducts()});
$("products").addEventListener("click",e=>{const d=e.target.closest("[data-detail]"),a=e.target.closest("[data-add]");if(d)openDetail(Number(d.dataset.detail));if(a)add(Number(a.dataset.add))});
$("detailBody").addEventListener("click",e=>{const s=e.target.closest("[data-size]");if(s){selectedSize=s.dataset.size;document.querySelectorAll("[data-size]").forEach(b=>b.classList.toggle("active",b===s))}if(e.target.closest("#detailAdd")&&selectedProduct){add(selectedProduct.id,selectedSize);$("detail").close()}});
$("cartItems").addEventListener("click",e=>{const rm=e.target.closest("[data-remove]"),q=e.target.closest("[data-qty]");if(rm){cart.splice(Number(rm.dataset.remove),1);save()}if(q){const i=Number(q.dataset.qty);cart[i].qty+=Number(q.dataset.delta);if(cart[i].qty<=0)cart.splice(i,1);save()}});
$("cartOpen").onclick=()=>cartVisible(true);$("cartClose").onclick=()=>cartVisible(false);$("shade").onclick=()=>cartVisible(false);$("checkoutOpen").onclick=checkoutView;
document.querySelectorAll("[data-close]").forEach(b=>b.onclick=()=>$(b.dataset.close).close());
$("checkoutBody").addEventListener("submit",e=>{if(e.target.id!=="checkoutForm")return;e.preventDefault();const name=new FormData(e.target).get("name").trim();const code="GG-"+Math.floor(100000+Math.random()*900000);cart=[];save();$("checkoutBody").innerHTML=`<div class="checkout-content"><span class="eyebrow">ORDER CONFIRMED / DEMO</span><h2>Pesanan simulasi berhasil!</h2><p>Terima kasih, ${escapeHTML(name)}. Tidak ada pembayaran yang dilakukan.</p><div class="receipt"><strong>Nomor pesanan: ${code}</strong><p>Nomor ini hanya contoh dan tidak tercatat di server.</p></div><button class="button full" id="finishCheckout">Kembali belanja</button></div>`});
$("checkoutBody").addEventListener("click",e=>{if(e.target.id==="finishCheckout")$("checkout").close()});
document.addEventListener("keydown",e=>{if(e.key==="Escape"&&$("cart").classList.contains("open"))cartVisible(false)});
renderProducts();renderCart();
