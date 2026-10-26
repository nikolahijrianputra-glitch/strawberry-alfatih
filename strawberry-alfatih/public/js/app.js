(function () {
  var burger = document.getElementById('burger'), menu = document.getElementById('menu');
  if (burger && menu) {
    burger.addEventListener('click', function () {
      var open = menu.classList.toggle('open');
      burger.setAttribute('aria-expanded', open);
    });
    menu.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () { menu.classList.remove('open'); burger.setAttribute('aria-expanded', 'false'); });
    });
  }
  // Skeleton + fallback bila foto gagal dimuat
  document.querySelectorAll('img[data-fallback]').forEach(function (img) {
    var box = img.parentNode;
    var done = function () { box.classList.remove('skeleton'); };
    if (img.complete && img.naturalWidth) { done(); }
    img.addEventListener('load', done);
    img.addEventListener('error', function () {
      done(); var s = document.createElement('span'); s.className = 'ph'; s.textContent = '🍓'; img.replaceWith(s);
    });
  });
  // Pencarian: kirim otomatis setelah berhenti mengetik
  var s = document.getElementById('search');
  if (s && s.form) {
    var t;
    s.addEventListener('input', function () { clearTimeout(t); t = setTimeout(function () { s.form.submit(); }, 600); });
  }
})();
