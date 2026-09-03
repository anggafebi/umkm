
document.addEventListener('DOMContentLoaded',()=>{
 const header=document.querySelector('.header');
 window.addEventListener('scroll',()=>{
   if(window.scrollY>30) header?.classList.add('scrolled');
   else header?.classList.remove('scrolled');
 });
 const observer=new IntersectionObserver(entries=>{
   entries.forEach(e=>{
     if(e.isIntersecting)e.target.classList.add('show');
   })
 },{threshold:.15});
 document.querySelectorAll('.card,.section h2,.cta').forEach(el=>{
   el.classList.add('fade-up'); observer.observe(el);
 });
});
