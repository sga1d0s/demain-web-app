// resources/js/pwa.js
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/service-worker.js')
    .then(() => console.log('[PWA] SW registrado'))
    .catch(err => console.error('[PWA] Error SW', err));
}

let deferredPrompt = null;

window.addEventListener('beforeinstallprompt', (e) => {
  console.log('[PWA] beforeinstallprompt');
  e.preventDefault();
  deferredPrompt = e;

  const btn = document.createElement('button');
  btn.textContent = '📲 Instalar app';
  Object.assign(btn.style, {
    position: 'fixed', bottom: '20px', right: '20px',
    padding: '10px 15px', background: '#0d6efd', color: '#fff',
    border: 'none', borderRadius: '5px', cursor: 'pointer', zIndex: 9999
  });
  document.body.appendChild(btn);

  btn.addEventListener('click', async () => {
    btn.style.display = 'none';
    deferredPrompt.prompt();
    const { outcome } = await deferredPrompt.userChoice;
    console.log('[PWA] userChoice:', outcome);
    deferredPrompt = null;
  });
});

window.addEventListener('appinstalled', () => {
  console.log('[PWA] App instalada');
});