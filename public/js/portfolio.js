/* Imran Hasan Badhon, portfolio behaviour. Plain JavaScript, no build step. */
(function () {
  'use strict';
  var root = document.documentElement;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var hoverOK = window.matchMedia('(hover: hover)').matches;
  function $(id) { return document.getElementById(id); }

  function cssRGB(name) {
    var v = getComputedStyle(root).getPropertyValue(name).trim();
    if (v.charAt(0) === '#') {
      if (v.length === 4) v = '#' + v[1] + v[1] + v[2] + v[2] + v[3] + v[3];
      return [parseInt(v.substr(1, 2), 16), parseInt(v.substr(3, 2), 16), parseInt(v.substr(5, 2), 16)];
    }
    return [79, 224, 196];
  }

  /* ---------- 3D perspective background (canvas) ---------- */
  (function () {
    var cv = $('bg'); if (!cv || !cv.getContext) return;
    var ctx = cv.getContext('2d'), W = 0, H = 0, dpr = 1, mx = 0, my = 0, tx = 0, ty = 0, scrollY = 0;
    var acc = cssRGB('--accent'), acc2 = cssRGB('--accent-2');
    var stars = [], N = 90, i;
    function rnd(a, b) { return a + Math.random() * (b - a); }
    for (i = 0; i < N; i++) stars.push({ x: rnd(-1, 1), y: rnd(-1, 1), z: rnd(0.1, 1) });
    function size() {
      dpr = Math.min(window.devicePixelRatio || 1, 2);
      W = window.innerWidth; H = window.innerHeight;
      cv.width = W * dpr; cv.height = H * dpr; ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }
    size(); window.addEventListener('resize', size);
    window.addEventListener('pointermove', function (e) { tx = e.clientX / W - 0.5; ty = e.clientY / H - 0.5; }, { passive: true });
    window.addEventListener('scroll', function () { scrollY = window.scrollY; }, { passive: true });

    var t0 = performance.now();
    function draw(now) {
      var t = (now - t0) / 1000;
      mx += (tx - mx) * 0.05; my += (ty - my) * 0.05;
      ctx.clearRect(0, 0, W, H);
      /* horizon sits lower as the page scrolls, so the grid feels like a floor you move across */
      var hy = H * (0.58 + Math.min(scrollY / 6000, 0.12)) + my * 18, vx = W / 2 + mx * 60;
      var g = ctx.createLinearGradient(0, hy, 0, H);
      g.addColorStop(0, 'rgba(' + acc[0] + ',' + acc[1] + ',' + acc[2] + ',0.0)');
      g.addColorStop(1, 'rgba(' + acc[0] + ',' + acc[1] + ',' + acc[2] + ',0.16)');
      ctx.lineWidth = 1; ctx.strokeStyle = g;
      /* rows: spacing grows toward the viewer */
      var phase = reduce ? 0 : (t * 0.18) % 1, k, y, d;
      ctx.beginPath();
      for (k = 0; k < 16; k++) {
        d = (k + phase) / 16; y = hy + (H - hy) * d * d;
        ctx.moveTo(0, y); ctx.lineTo(W, y);
      }
      /* columns: converge on the vanishing point */
      for (k = -14; k <= 14; k++) { ctx.moveTo(vx, hy); ctx.lineTo(vx + k * W * 0.11, H); }
      ctx.stroke();
      /* stars with depth */
      for (i = 0; i < N; i++) {
        var s = stars[i];
        if (!reduce) { s.z -= 0.0007; if (s.z < 0.06) { s.z = 1; s.x = rnd(-1, 1); s.y = rnd(-1, 1); } }
        var sx = W / 2 + (s.x / s.z) * W * 0.12 + mx * 40 / s.z * 0.2, sy = H * 0.34 + (s.y / s.z) * H * 0.1 + my * 30 / s.z * 0.2;
        if (sy > hy - 4 || sx < -10 || sx > W + 10 || sy < -10) continue;
        var a = (1 - s.z) * 0.9, r = 0.4 + (1 - s.z) * 1.6, c = i % 7 === 0 ? acc2 : acc;
        ctx.fillStyle = 'rgba(' + c[0] + ',' + c[1] + ',' + c[2] + ',' + a.toFixed(2) + ')';
        ctx.beginPath(); ctx.arc(sx, sy, r, 0, 6.2832); ctx.fill();
      }
      if (!reduce) requestAnimationFrame(draw);
    }
    requestAnimationFrame(draw);
  })();

  /* ---------- hero: tilt + orbit ---------- */
  var stage = $('stage'), card = $('card3d');
  if (stage && card && hoverOK && !reduce) {
    stage.addEventListener('pointermove', function (e) {
      if (e.pointerType !== 'mouse') return;
      var r = stage.getBoundingClientRect();
      var x = (e.clientX - r.left) / r.width - 0.5, y = (e.clientY - r.top) / r.height - 0.5;
      stage.classList.add('live');
      card.style.setProperty('--ry', (x * 20 - 2).toFixed(2) + 'deg');
      card.style.setProperty('--rx', (-y * 14 + 2).toFixed(2) + 'deg');
    });
    stage.addEventListener('pointerleave', function () {
      stage.classList.remove('live');
      card.style.setProperty('--ry', '-8deg'); card.style.setProperty('--rx', '2deg');
    });
  }

  var orbit = $('orbit');
  if (orbit) {
    var tags = Array.prototype.slice.call(orbit.children), n = tags.length;
    var ot = 0;
    function place() {
      var w = orbit.clientWidth, h = orbit.clientHeight, cx = w / 2, cy = h * 0.5;
      var rx = Math.min(w * 0.46, w / 2 - 62), ry = h * 0.34;
      tags.forEach(function (el, i) {
        var a = ot + i * (Math.PI * 2 / n), depth = (Math.sin(a) + 1) / 2;
        var x = Math.cos(a) * rx, y = Math.sin(a) * ry, sc = 0.78 + depth * 0.28;
        el.style.transform = 'translate(' + (cx + x - el.offsetWidth / 2).toFixed(1) + 'px,' + (cy + y - el.offsetHeight / 2).toFixed(1) + 'px) scale(' + sc.toFixed(3) + ')';
        el.style.opacity = (0.4 + depth * 0.6).toFixed(2);
        el.style.zIndex = depth > 0.5 ? 5 : 0;
      });
    }
    place();
    window.addEventListener('resize', place);
    if (!reduce) (function spin() { ot += 0.006; place(); requestAnimationFrame(spin); })();
  }

  /* ---------- tilt: cards and mockups (mouse only) ---------- */
  if (!reduce && hoverOK) {
    Array.prototype.forEach.call(document.querySelectorAll('.tilt'), function (el) {
      el.addEventListener('pointermove', function (e) {
        if (e.pointerType !== 'mouse') return;
        var r = el.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5, y = (e.clientY - r.top) / r.height - 0.5;
        el.style.transform = 'rotateX(' + (-y * 7).toFixed(2) + 'deg) rotateY(' + (x * 9).toFixed(2) + 'deg) translateY(-3px)';
      });
      el.addEventListener('pointerleave', function () { el.style.transform = ''; });
    });
    Array.prototype.forEach.call(document.querySelectorAll('.mock3d'), function (el) {
      var wrap = el.parentNode;
      wrap.addEventListener('pointermove', function (e) {
        if (e.pointerType !== 'mouse') return;
        var r = wrap.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5, y = (e.clientY - r.top) / r.height - 0.5;
        el.classList.add('live');
        el.style.setProperty('--my', (-14 + x * 22).toFixed(2) + 'deg');
        el.style.setProperty('--mx', (6 - y * 14).toFixed(2) + 'deg');
      });
      wrap.addEventListener('pointerleave', function () {
        el.classList.remove('live'); el.style.setProperty('--my', '-14deg'); el.style.setProperty('--mx', '6deg');
      });
    });
  }

  /* ---------- reveal on scroll ---------- */
  if ('IntersectionObserver' in window && !reduce) {
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.remove('pre'); io.unobserve(e.target); } });
    }, { threshold: 0.06, rootMargin: '0px 0px -6% 0px' });
    Array.prototype.forEach.call(document.querySelectorAll('.rv'), function (el) {
      if (el.getBoundingClientRect().top > window.innerHeight * 0.92) { el.classList.add('pre'); io.observe(el); }
    });
  }

  /* ---------- active nav link ---------- */
  var links = Array.prototype.slice.call(document.querySelectorAll('.nav a')).filter(function (a) { return a.hash && document.querySelector(a.hash); });
  var ticking = false;
  function onScroll() {
    ticking = false;
    var cur = -1;
    links.forEach(function (a, i) { var s = document.querySelector(a.hash); if (s.getBoundingClientRect().top <= 140) cur = i; });
    links.forEach(function (a, i) { a.classList.toggle('on', i === cur); });
  }
  window.addEventListener('scroll', function () { if (!ticking) { ticking = true; requestAnimationFrame(onScroll); } }, { passive: true });
  onScroll();

  /* ---------- contact: copy email, preset the message type from hero buttons ---------- */
  var mailEl = $('mailText'), copyBtn = $('copyMail'), note = $('copyNote');
  if (mailEl && copyBtn) copyBtn.addEventListener('click', function () {
    function fallback() {
      var r = document.createRange(); r.selectNodeContents(mailEl);
      var s = window.getSelection(); s.removeAllRanges(); s.addRange(r); note.textContent = 'Selected, press copy';
    }
    try { navigator.clipboard.writeText(mailEl.textContent).then(function () { note.textContent = 'Copied'; }, fallback); } catch (e) { fallback(); }
    setTimeout(function () { note.textContent = ''; }, 2600);
  });
  var typeSel = $('type');
  Array.prototype.forEach.call(document.querySelectorAll('[data-type]'), function (a) {
    a.addEventListener('click', function () { if (typeSel) typeSel.value = a.getAttribute('data-type'); });
  });

  /* ---------- Vision Lab: real 3x3 convolutions on your own image ---------- */
  var photo = $('photo');
  function accentLight() { return cssRGB('--accent'); }
  function paintEdges() {}
  if ($('labStage') && photo) {
  function sobelMag(g, w, h) {
    var mag = new Float32Array(w * h), x, y, i, gx, gy;
    for (y = 1; y < h - 1; y++) for (x = 1; x < w - 1; x++) {
      i = y * w + x;
      gx = -g[i - w - 1] + g[i - w + 1] - 2 * g[i - 1] + 2 * g[i + 1] - g[i + w - 1] + g[i + w + 1];
      gy = -g[i - w - 1] - 2 * g[i - w] - g[i - w + 1] + g[i + w - 1] + 2 * g[i + w] + g[i + w + 1];
      mag[i] = Math.max(0, Math.sqrt(gx * gx + gy * gy) - 48);
    }
    return mag;
  }

  var labStage = document.getElementById('labStage'), A = document.getElementById('labA'), B = document.getElementById('labB');
  var labRange = document.getElementById('labRange'), labTag = document.getElementById('labTag');
  var kernelEl = document.getElementById('kernel'), kernelCap = document.getElementById('kernelCap'), labNote = document.getElementById('labNote');
  var LAB = {
    edges:      { tag: 'Edges', cap: 'Sobel kernel (horizontal)', k: [-1, 0, 1, -2, 0, 2, -1, 0, 1], note: 'Sobel kernels measure how fast brightness changes from pixel to pixel. Sharp changes become bright lines. The first layers of a CNN learn filters very much like this.' },
    activation: { tag: 'Feature map', cap: 'Vertical-edge kernel + ReLU', k: [-1, 0, 1, -1, 0, 1, -1, 0, 1], note: 'One filter, then ReLU, which keeps only positive responses. This is roughly what a single channel of a first convolution layer passes on to the next layer.' },
    emboss:     { tag: 'Emboss', cap: 'Emboss kernel', k: [-2, -1, 0, -1, 1, 1, 0, 1, 2], note: 'A directional kernel that compares each pixel with its neighbours on opposite sides, which makes surfaces look raised.' },
    sharpen:    { tag: 'Sharpen', cap: 'Sharpen kernel', k: [0, -1, 0, -1, 5, -1, 0, -1, 0], note: 'The centre pixel is boosted and its four neighbours are subtracted, so local contrast goes up and edges look crisper.' },
    blur:       { tag: 'Blur', cap: 'Gaussian blur kernel (divided by 16)', k: [1, 2, 1, 2, 4, 2, 1, 2, 1], note: 'Each pixel becomes a weighted average of its neighbours. Smoothing like this is a common first step before detecting edges.' }
  };
  var kind = 'edges', base = null, LW = 0, LH = 0, cache = {};
  var photoSrc = photo.src;

  function drawKernel() {
    var d = LAB[kind], maxv = 0, i;
    for (i = 0; i < 9; i++) maxv = Math.max(maxv, Math.abs(d.k[i]));
    kernelEl.innerHTML = '';
    for (i = 0; i < 9; i++) {
      var s = document.createElement('span'), v = d.k[i];
      s.textContent = v; s.className = v > 0 ? 'pos' : (v < 0 ? 'neg' : '');
      s.style.setProperty('--p', Math.round(Math.abs(v) / maxv * 70));
      kernelEl.appendChild(s);
    }
    kernelCap.textContent = d.cap; labNote.textContent = d.note; labTag.textContent = d.tag;
  }
  function lerp3(t, c) { t = Math.max(0, Math.min(1, t)); return [10 + (c[0] - 10) * t, 14 + (c[1] - 14) * t, 26 + (c[2] - 26) * t]; }
  function run(k) {
    var w = LW, h = LH, src = base.data, out = new ImageData(w, h), o = out.data, n = w * h, i, x, y, ch, s, kk = LAB[k].k;
    var g = new Float32Array(n);
    for (i = 0; i < n; i++) g[i] = 0.299 * src[i * 4] + 0.587 * src[i * 4 + 1] + 0.114 * src[i * 4 + 2];
    var acc = accentLight(), rgb;
    for (i = 0; i < n; i++) o[i * 4 + 3] = 255;
    if (k === 'emboss') { for (i = 0; i < n; i++) o[i * 4] = o[i * 4 + 1] = o[i * 4 + 2] = 128; }
    if (k === 'activation') { rgb = lerp3(0, acc); for (i = 0; i < n; i++) { o[i * 4] = rgb[0]; o[i * 4 + 1] = rgb[1]; o[i * 4 + 2] = rgb[2]; } }
    if (k === 'edges') {
      var mag = sobelMag(g, w, h);
      for (i = 0; i < n; i++) { rgb = lerp3(Math.pow(Math.min(1, mag[i] / 330), 0.8), acc); o[i * 4] = rgb[0]; o[i * 4 + 1] = rgb[1]; o[i * 4 + 2] = rgb[2]; }
    } else if (k === 'activation' || k === 'emboss') {
      for (y = 1; y < h - 1; y++) for (x = 1; x < w - 1; x++) {
        i = y * w + x;
        s = kk[0] * g[i - w - 1] + kk[1] * g[i - w] + kk[2] * g[i - w + 1] + kk[3] * g[i - 1] + kk[4] * g[i] + kk[5] * g[i + 1] + kk[6] * g[i + w - 1] + kk[7] * g[i + w] + kk[8] * g[i + w + 1];
        if (k === 'activation') { rgb = lerp3(Math.max(0, s) / 330, acc); o[i * 4] = rgb[0]; o[i * 4 + 1] = rgb[1]; o[i * 4 + 2] = rgb[2]; }
        else { s = Math.max(0, Math.min(255, s + 128)); o[i * 4] = o[i * 4 + 1] = o[i * 4 + 2] = s; }
      }
    } else {
      var div = k === 'blur' ? 16 : 1;
      for (y = 1; y < h - 1; y++) for (x = 1; x < w - 1; x++) {
        i = y * w + x;
        for (ch = 0; ch < 3; ch++) {
          s = kk[0] * src[(i - w - 1) * 4 + ch] + kk[1] * src[(i - w) * 4 + ch] + kk[2] * src[(i - w + 1) * 4 + ch] + kk[3] * src[(i - 1) * 4 + ch] + kk[4] * src[i * 4 + ch] + kk[5] * src[(i + 1) * 4 + ch] + kk[6] * src[(i + w - 1) * 4 + ch] + kk[7] * src[(i + w) * 4 + ch] + kk[8] * src[(i + w + 1) * 4 + ch];
          o[i * 4 + ch] = Math.max(0, Math.min(255, s / div));
        }
      }
    }
    return out;
  }
  function labRender() {
    if (!base) return;
    if (!cache[kind]) cache[kind] = run(kind);
    B.getContext('2d').putImageData(cache[kind], 0, 0);
    drawKernel();
  }
  function setSource(img) {
    var iw = img.naturalWidth || img.width, ih = img.naturalHeight || img.height;
    if (!iw || !ih) return;
    var sc = Math.min(1, 560 / Math.max(iw, ih));
    LW = Math.max(8, Math.round(iw * sc)); LH = Math.max(8, Math.round(ih * sc));
    A.width = B.width = LW; A.height = B.height = LH;
    var cx = A.getContext('2d'); cx.drawImage(img, 0, 0, LW, LH);
    base = cx.getImageData(0, 0, LW, LH); cache = {};
    labStage.style.aspectRatio = LW + ' / ' + LH;
    labRender();
  }
  function useMyPhoto() { var im = new Image(); im.onload = function () { setSource(im); }; im.src = photoSrc; }
  useMyPhoto();

  document.getElementById('seg').addEventListener('click', function (e) {
    var b = e.target.closest('button[data-k]'); if (!b) return;
    kind = b.getAttribute('data-k');
    Array.prototype.forEach.call(this.querySelectorAll('button'), function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
    labRender();
  });
  var fileIn = document.getElementById('labFile'), fine = document.getElementById('labFine');
  document.getElementById('labUpload').addEventListener('click', function () { fileIn.click(); });
  document.getElementById('labReset').addEventListener('click', function () { useMyPhoto(); fine.textContent = 'Processed locally with JavaScript. Nothing is uploaded.'; });
  fileIn.addEventListener('change', function () {
    var f = fileIn.files && fileIn.files[0]; if (!f) return;
    if (!/^image\//.test(f.type)) { fine.textContent = 'That file is not an image. Try a JPG or PNG.'; return; }
    var rd = new FileReader();
    rd.onload = function () {
      var im = new Image();
      im.onload = function () { setSource(im); fine.textContent = 'Your image stays on your device.'; };
      im.onerror = function () { fine.textContent = 'This image could not be read. Try a JPG or PNG.'; };
      im.src = rd.result;
    };
    rd.readAsDataURL(f);
    fileIn.value = '';
  });
  function setSplit(p) { p = Math.max(0, Math.min(100, p)); labStage.style.setProperty('--s', p + '%'); labRange.value = p; }
  labRange.addEventListener('input', function () { setSplit(+labRange.value); });
  labStage.addEventListener('pointermove', function (e) {
    if (e.pointerType === 'mouse' || e.buttons) { var r = labStage.getBoundingClientRect(); setSplit((e.clientX - r.left) / r.width * 100); }
  });
  labStage.addEventListener('pointerdown', function (e) { var r = labStage.getBoundingClientRect(); setSplit((e.clientX - r.left) / r.width * 100); });

  /* redraw colour-dependent canvases when the theme changes */

  }
})();
