/* Interaksi CV: pip skill, avatar pixel, bintang latar, menu angka, salin email */
(function () {
  var reduce = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* skill pips */
  document.querySelectorAll(".pips").forEach(function (el) {
    var n = +el.dataset.n;
    for (var i = 0; i < 5; i++) {
      var p = document.createElement("i");
      if (i < n) p.className = "on";
      el.appendChild(p);
    }
  });

  /* avatar pixel */
  var map = [
    "....HHHHHH....",
    "...HHHHHHHH...",
    "..HHHHHHHHHH..",
    "..HHSSSSSSHH..",
    "..HSSESSESSH..",
    "..SSSSSSSSSS..",
    "...SSSMMSSS...",
    "....SSSSSS....",
    "..GGGGGGGGGG..",
    ".GGGGDDGGGGGG.",
    "GGSGGGGGGGGSGG",
    "GGSGLLLLLLGSGG",
    "SS.GLLKKLLG.SS",
    "...LLLLLLLL...",
    "...PPP..PPP...",
    "...PPP..PPP...",
    "..BBBB..BBBB.."
  ];
  var pal = { H:"#2b1d14", S:"#f1c08f", E:"#13112b", M:"#b5543c", G:"#2fae6b", D:"#1f7a4a", L:"#c9cbe0", K:"#5cc8ff", P:"#3a3f7a", B:"#f4f0e3" };
  var sc = document.getElementById("sprite"), sx = sc && sc.getContext("2d");
  if (sx)
  map.forEach(function (row, y) {
    for (var x = 0; x < row.length; x++) {
      var c = pal[row[x]];
      if (c) { sx.fillStyle = c; sx.fillRect(x, y, 1, 1); }
    }
  });
  if (sc && !reduce) {
    var up = false;
    setInterval(function () { up = !up; sc.style.transform = up ? "translateY(-4px)" : "none"; }, 520);
  }

  /* bintang latar */
  var cv = document.getElementById("stars"), cx = cv.getContext("2d"), stars = [];

  /* bintang jatuh: muncul jarang, satu per satu (jeda acak 9–18 detik) */
  var meteor = null, nextMeteor = 4000 + Math.random() * 4000;
  function spawnMeteor(time) {
    var speed = 0.55 + Math.random() * 0.25;            // piksel per milidetik
    meteor = {
      x: cv.width * (0.35 + Math.random() * 0.6),
      y: cv.height * Math.random() * 0.3,
      vx: -speed, vy: speed * (0.4 + Math.random() * 0.2), // meluncur ke kiri bawah
      t0: time, dur: 1100 + Math.random() * 500
    };
  }
  function drawMeteor(time) {
    if (!meteor && time >= nextMeteor) spawnMeteor(time);
    if (!meteor) return;
    var e = time - meteor.t0, p = e / meteor.dur;
    if (p >= 1) { meteor = null; nextMeteor = time + 9000 + Math.random() * 9000; return; }
    var hx = meteor.x + meteor.vx * e, hy = meteor.y + meteor.vy * e;
    var fade = p < 0.75 ? 1 : (1 - p) / 0.25;
    for (var k = 0; k < 14; k++) {                       // ekor berupa kotak pixel yang memudar
      var tx = hx - meteor.vx * k * 14, ty = hy - meteor.vy * k * 14;
      var a = (1 - k / 14) * fade, s = k < 2 ? 4 : (k < 6 ? 3 : 2);
      cx.fillStyle = k === 0 ? "rgba(255,255,255," + a.toFixed(2) + ")" : "rgba(255,214,120," + a.toFixed(2) + ")";
      cx.fillRect(Math.round(tx / 2) * 2, Math.round(ty / 2) * 2, s, s);
    }
  }
  function size() {
    cv.width = innerWidth; cv.height = innerHeight;
    stars = [];
    var n = Math.round(innerWidth * innerHeight / 9000);
    for (var i = 0; i < n; i++) stars.push({ x: Math.random()*cv.width|0, y: Math.random()*cv.height|0, s: Math.random() < .15 ? 3 : 2, t: Math.random()*6 });
  }
  function draw(time) {
    cx.clearRect(0, 0, cv.width, cv.height);
    stars.forEach(function (st) {
      var a = reduce ? .5 : .25 + .45 * (1 + Math.sin(time/700 + st.t)) / 2;
      cx.fillStyle = "rgba(244,240,227," + a.toFixed(2) + ")";
      cx.fillRect(st.x, st.y, st.s, st.s);
    });
    if (!reduce) { drawMeteor(time); requestAnimationFrame(draw); }
  }
  size(); addEventListener("resize", function () { size(); if (reduce) draw(0); });
  reduce ? draw(0) : requestAnimationFrame(draw);

  /* menu: tombol angka + penanda aktif */
  var links = document.querySelectorAll(".hud a");
  var ids = Array.prototype.map.call(links, function (a) { return a.getAttribute("href").slice(1); });
  addEventListener("keydown", function (e) {
    if (e.target.closest && e.target.closest("input,textarea")) return;
    var i = parseInt(e.key, 10);
    if (i >= 1 && i <= ids.length) document.getElementById(ids[i-1]).scrollIntoView({ behavior: reduce ? "auto" : "smooth" });
  });
  function mark() {
    var cur = null;
    ids.forEach(function (id, i) { if (document.getElementById(id).getBoundingClientRect().top < 140) cur = i; });
    links.forEach(function (a, i) { a.classList.toggle("on", i === cur); });
  }
  addEventListener("scroll", mark, { passive: true }); mark();

  /* filter jenis quest (kerja / organisasi / proyek / praktikum) */
  var fBtns = document.querySelectorAll(".f-btn");
  fBtns.forEach(function (b) {
    b.addEventListener("click", function () {
      var j = b.dataset.jenis;
      fBtns.forEach(function (x) { x.classList.toggle("on", x === b); });
      document.querySelectorAll(".quest").forEach(function (q) {
        q.hidden = j !== "semua" && q.dataset.jenis !== j;
      });
    });
  });

  /* salin email */
  var btn = document.getElementById("copy");
  if (btn) btn.addEventListener("click", function () {
    var done = function (t) { btn.textContent = t; setTimeout(function () { btn.textContent = "SALIN EMAIL"; }, 1800); };
    try {
      navigator.clipboard.writeText(btn.dataset.email).then(function () { done("TERSALIN!"); }, function () { done("SALIN MANUAL"); });
    } catch (err) { done("SALIN MANUAL"); }
  });
})();
