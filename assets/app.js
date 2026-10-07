(function(){
  const $=(s,r=document)=>r.querySelector(s), $$=(s,r=document)=>[...r.querySelectorAll(s)];
  // Mobile menu + dropdowns
  $$('[data-toggle]').forEach(b=>b.addEventListener('click',e=>{
    e.stopPropagation(); const t=document.getElementById(b.dataset.toggle); if(!t)return;
    const open=t.classList.toggle('hidden')===false; b.setAttribute('aria-expanded',open);
    if(b.dataset.dropdown!==undefined) $$('[data-dropdown-panel]').forEach(p=>{if(p!==t){p.classList.add('hidden');}});
  }));
  document.addEventListener('click',()=>{$$('[data-dropdown-panel]').forEach(p=>p.classList.add('hidden'));$$('[data-dropdown]').forEach(b=>b.setAttribute('aria-expanded','false'));});
  document.addEventListener('keydown',e=>{if(e.key==='Escape'){$$('[data-dropdown-panel]').forEach(p=>p.classList.add('hidden'));}});
  // FAQ accordion
  $$('.acc-item button').forEach(b=>b.addEventListener('click',()=>{const it=b.closest('.acc-item');const o=it.classList.toggle('open');b.setAttribute('aria-expanded',o);}));
  // Favorites without a page reload (falls back to normal form post)
  $$('.fav-form').forEach(f=>f.addEventListener('submit',async ev=>{
    ev.preventDefault(); const btn=$('.fav-btn',f);
    try{ const r=await fetch(f.action,{method:'POST',body:new FormData(f),headers:{'X-Requested-With':'fetch'}});
      if(!r.ok) throw 0; const j=await r.json(); btn.setAttribute('aria-pressed',j.favorited); btn.setAttribute('aria-label',j.favorited?'Remove from favorites':'Save to favorites');
    }catch(_){ f.submit(); }
  }));
  // Cookie banner (necessary cookies only)
  const banner=$('#cookie-banner'), dlg=$('#cookie-dialog');
  const set=()=>{document.cookie='lynx_cookies=accepted; max-age=31536000; path=/; SameSite=Lax';banner&&banner.remove();};
  if(banner){ if(document.cookie.includes('lynx_cookies=')) banner.remove(); else banner.classList.remove('hidden'); }
  $$('[data-cookie-accept]').forEach(b=>b.addEventListener('click',()=>{set(); dlg&&dlg.open&&dlg.close();}));
  $$('[data-cookie-settings]').forEach(b=>b.addEventListener('click',()=>dlg&&dlg.showModal()));
  $$('[data-dialog-close]').forEach(b=>b.addEventListener('click',()=>dlg&&dlg.close()));
  // Admin sidebar toggle is handled by data-toggle above
})();
