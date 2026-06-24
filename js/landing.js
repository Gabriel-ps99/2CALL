/* ============================================================
   2CALL CUIABÁ — interações
   ============================================================ */
(function () {
  'use strict';

  var WA_NUMBER = '5565981164887';
  var EMAIL = 'junior.lannes@2cmovel.com.br';

  /* ---- mobile menu ---- */
  var toggle = document.querySelector('.menu-toggle');
  var nav = document.querySelector('.nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      nav.classList.toggle('open');
    });
    nav.addEventListener('click', function (e) {
      if (e.target.tagName === 'A') nav.classList.remove('open');
    });
  }

  /* ---- reveal on scroll ---- */
  var revealEls = [].slice.call(document.querySelectorAll('.reveal'));
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (en) {
      if (en.isIntersecting) {
        en.target.classList.add('show');
        io.unobserve(en.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
  revealEls.forEach(function (el) { io.observe(el); });
  // safety net: never leave content hidden if the observer is throttled
  setTimeout(function () {
    revealEls.forEach(function (el) {
      el.classList.add('show');
      el.style.transition = 'none';
      el.style.opacity = '1';
      el.style.transform = 'none';
    });
  }, 2600);

  /* ---- hero SMS sequence ---- */
  var thread = document.getElementById('smsThread');
  if (thread) {
    var msgs = [
      { t: 'Promo relâmpago hoje! 30% OFF em toda loja. Mostre este SMS no caixa. 🛍️', time: '09:14' },
      { t: 'Seu pedido #2841 saiu pra entrega e chega em até 40min. Acompanhe pelo link.', time: '09:15' },
      { t: 'Cuiabá, sua fatura vence amanhã. Pague pelo PIX e ganhe desconto. 2Call', time: '09:16' }
    ];
    var typing = thread.querySelector('.sms-typing');
    var i = 0;
    function showNext() {
      if (i >= msgs.length) {
        // loop softly after a pause
        setTimeout(resetThread, 4200);
        return;
      }
      if (typing) typing.classList.add('in');
      setTimeout(function () {
        if (typing) typing.classList.remove('in');
        var el = document.createElement('div');
        el.className = 'sms';
        el.innerHTML = msgs[i].t + '<time>' + msgs[i].time + '</time>';
        thread.insertBefore(el, typing);
        setTimeout(function () { el.classList.add('in'); }, 40);
        i++;
        setTimeout(showNext, 1300);
      }, 900);
    }
    function resetThread() {
      thread.querySelectorAll('.sms').forEach(function (n) { n.remove(); });
      i = 0;
      showNext();
    }
    // hero is always at the top — kick off shortly after load
    setTimeout(showNext, 700);
  }

  /* ---- form -> whatsapp ---- */
  var form = document.getElementById('orcamentoForm');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var d = new FormData(form);
      var nome = (d.get('nome') || '').toString().trim();
      var empresa = (d.get('empresa') || '').toString().trim();
      var fone = (d.get('telefone') || '').toString().trim();
      var tipo = (d.get('tipo') || '').toString().trim();
      var publico = (d.get('publico') || '').toString().trim();

      var lines = [
        'Olá, 2Call Cuiabá! Quero um orçamento de SMS marketing.',
        '',
        'Nome: ' + nome,
        empresa ? 'Empresa: ' + empresa : '',
        fone ? 'WhatsApp/Telefone: ' + fone : '',
        tipo ? 'Tipo de segmentação: ' + tipo : '',
        publico ? 'Público-alvo / detalhes: ' + publico : ''
      ].filter(Boolean);

      var msg = encodeURIComponent(lines.join('\n'));
      window.open('https://wa.me/' + WA_NUMBER + '?text=' + msg, '_blank');
    });
  }

  /* build wa / mail links present in page */
  document.querySelectorAll('[data-wa]').forEach(function (a) {
    var txt = a.getAttribute('data-wa') || 'Olá, 2Call Cuiabá! Gostaria de um orçamento de SMS marketing.';
    a.setAttribute('href', 'https://wa.me/' + WA_NUMBER + '?text=' + encodeURIComponent(txt));
    a.setAttribute('target', '_blank');
  });
  document.querySelectorAll('[data-mail]').forEach(function (a) {
    a.setAttribute('href', 'mailto:' + EMAIL + '?subject=' + encodeURIComponent('Orçamento SMS marketing - 2Call Cuiabá'));
  });

  /* year */
  var yr = document.getElementById('year');
  if (yr) yr.textContent = new Date().getFullYear();
})();
