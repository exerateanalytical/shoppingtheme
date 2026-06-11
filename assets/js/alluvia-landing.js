/* Alluvia Peptides — Landing Page Scripts */
(function () {
  'use strict';

  /* ── Particle Canvas ── */
  function initParticles() {
    var canvas = document.getElementById('hero-canvas');
    if (!canvas) return;
    var ctx = canvas.getContext('2d');
    var particles = [];
    var W, H;

    function resize() {
      W = canvas.width  = canvas.offsetWidth;
      H = canvas.height = canvas.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    function Particle() {
      this.reset();
    }
    Particle.prototype.reset = function () {
      this.x  = Math.random() * W;
      this.y  = Math.random() * H;
      this.r  = Math.random() * 1.5 + 0.3;
      this.vx = (Math.random() - 0.5) * 0.35;
      this.vy = (Math.random() - 0.5) * 0.35;
      this.alpha = Math.random() * 0.5 + 0.1;
      this.color = Math.random() > 0.6 ? '#00c6b3' : '#c8a96e';
    };
    Particle.prototype.update = function () {
      this.x += this.vx;
      this.y += this.vy;
      if (this.x < -10) this.x = W + 10;
      if (this.x > W + 10) this.x = -10;
      if (this.y < -10) this.y = H + 10;
      if (this.y > H + 10) this.y = -10;
    };

    for (var i = 0; i < 90; i++) particles.push(new Particle());

    function draw() {
      ctx.clearRect(0, 0, W, H);

      /* draw connection lines */
      for (var a = 0; a < particles.length; a++) {
        for (var b = a + 1; b < particles.length; b++) {
          var dx = particles[a].x - particles[b].x;
          var dy = particles[a].y - particles[b].y;
          var dist = Math.sqrt(dx * dx + dy * dy);
          if (dist < 110) {
            ctx.beginPath();
            ctx.strokeStyle = 'rgba(0,198,179,' + (0.08 * (1 - dist / 110)) + ')';
            ctx.lineWidth = 0.6;
            ctx.moveTo(particles[a].x, particles[a].y);
            ctx.lineTo(particles[b].x, particles[b].y);
            ctx.stroke();
          }
        }
      }

      /* draw dots */
      particles.forEach(function (p) {
        p.update();
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = p.color;
        ctx.globalAlpha = p.alpha;
        ctx.fill();
        ctx.globalAlpha = 1;
      });

      requestAnimationFrame(draw);
    }
    draw();
  }

  /* ── Sticky Nav ── */
  function initNav() {
    var nav = document.querySelector('.alluvia-nav');
    if (!nav) return;
    window.addEventListener('scroll', function () {
      if (window.scrollY > 60) {
        nav.classList.add('scrolled');
      } else {
        nav.classList.remove('scrolled');
      }
    }, { passive: true });
  }

  /* ── Mobile Nav ── */
  function initMobileNav() {
    var hamburger = document.querySelector('.nav-hamburger');
    var overlay   = document.querySelector('.mobile-nav-overlay');
    var closeBtn  = document.querySelector('.mobile-nav-close');
    if (!hamburger || !overlay) return;

    hamburger.addEventListener('click', function () {
      overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
    });

    function close() {
      overlay.classList.remove('open');
      document.body.style.overflow = '';
    }

    if (closeBtn) closeBtn.addEventListener('click', close);
    overlay.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', close);
    });
  }

  /* ── Smooth Scroll ── */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
      a.addEventListener('click', function (e) {
        var target = document.querySelector(this.getAttribute('href'));
        if (!target) return;
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  }

  /* ── Intersection Observer Reveals ── */
  function initReveal() {
    var items = document.querySelectorAll('.reveal, .cat-card, .process-step, .testi-card, .stats-item, .cert-card');
    if (!items.length) return;

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('reveal-done');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    items.forEach(function (el) { observer.observe(el); });
  }

  /* ── Counter Animation ── */
  function animateCounter(el, target, suffix, duration) {
    suffix = suffix || '';
    duration = duration || 2000;
    var start = 0;
    var startTime = null;

    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      var progress = Math.min((timestamp - startTime) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3);
      var value = Math.floor(eased * target);
      el.textContent = value.toLocaleString() + suffix;
      if (progress < 1) requestAnimationFrame(step);
      else el.textContent = target.toLocaleString() + suffix;
    }
    requestAnimationFrame(step);
  }

  function initCounters() {
    var counters = document.querySelectorAll('[data-count]');
    if (!counters.length) return;

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var el     = entry.target;
          var target = parseInt(el.getAttribute('data-count'), 10);
          var suffix = el.getAttribute('data-suffix') || '';
          animateCounter(el, target, suffix, 1800);
          observer.unobserve(el);
        }
      });
    }, { threshold: 0.5 });

    counters.forEach(function (el) { observer.observe(el); });
  }

  /* ── Typewriter Hero ── */
  function initTypewriter() {
    var el = document.querySelector('.hero-typewriter');
    if (!el) return;
    var words = ['Younger', 'Stronger', 'Healthier', 'Vibrant', 'Radiant'];
    var idx = 0;
    var charIdx = 0;
    var deleting = false;
    var delay = 120;

    function type() {
      var word = words[idx];
      if (!deleting) {
        el.textContent = word.substring(0, charIdx + 1);
        charIdx++;
        if (charIdx === word.length) {
          deleting = true;
          delay = 2200;
        } else {
          delay = 100;
        }
      } else {
        el.textContent = word.substring(0, charIdx - 1);
        charIdx--;
        if (charIdx === 0) {
          deleting = false;
          idx = (idx + 1) % words.length;
          delay = 300;
        } else {
          delay = 55;
        }
      }
      setTimeout(type, delay);
    }
    setTimeout(type, 1200);
  }

  /* ── DNA Rungs ── */
  function buildDNA() {
    var container = document.querySelector('.about-dna-visual');
    if (!container) return;
    var totalRungs = 10;
    var heights = [20, 30, 45, 55, 65, 75, 85, 100, 120, 150];
    var widths  = [70, 90, 80, 100, 75, 88, 95, 72, 85, 92];
    for (var i = 0; i < totalRungs; i++) {
      var rung = document.createElement('div');
      rung.className = 'dna-rung';
      rung.style.top   = heights[i] + 'px';
      rung.style.width = widths[i] + 'px';
      rung.style.animationDelay = (i * 0.18) + 's';
      container.appendChild(rung);
    }
  }

  /* ── Newsletter form ── */
  function initForm() {
    var form = document.querySelector('.email-form');
    if (!form) return;
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn = form.querySelector('button');
      var input = form.querySelector('input');
      if (!input.value.trim()) return;
      btn.textContent = 'Subscribed!';
      btn.style.background = '#00c6b3';
      input.value = '';
      setTimeout(function () {
        btn.textContent = 'Join Now';
        btn.style.background = '';
      }, 3500);
    });
  }

  /* ── Init all ── */
  document.addEventListener('DOMContentLoaded', function () {
    initParticles();
    initNav();
    initMobileNav();
    initSmoothScroll();
    initReveal();
    initCounters();
    initTypewriter();
    buildDNA();
    initForm();
  });
})();
