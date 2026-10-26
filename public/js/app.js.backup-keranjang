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

// Animasi scroll produk Strawberry Alfatih
(() => {
    const initScrollReveal = () => {
        const targets = document.querySelectorAll(
            '.product-card, .product-item, .product-grid > *, .products-grid > *'
        );

        if (!('IntersectionObserver' in window)) {
            return;
        }

        targets.forEach((element) => {
            if (element.dataset.scrollRevealReady) return;

            element.dataset.scrollRevealReady = 'true';
            element.classList.add('scroll-reveal');
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px 30px 0px'
        });

        targets.forEach((element) => {
            if (element.classList.contains('scroll-reveal')) {
                observer.observe(element);
            }
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initScrollReveal, { once: true });
    } else {
        initScrollReveal();
    }
})();
