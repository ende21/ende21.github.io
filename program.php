<?php
include 'header.php';
include 'admin/config/conn_db.php';

// Ambil data berita terbaru terlebih dahulu
$query = "SELECT * FROM berita ORDER BY tanggal DESC, id DESC";
$result = mysqli_query($conn, $query);

// Fungsi ambil gambar dari situs berita dengan error handling
function ambilGambar($url)
{
  $cache_file = 'cache/' . md5($url) . '.txt';
  if (file_exists($cache_file) && (time() - filemtime($cache_file) < 86400)) {
    return file_get_contents($cache_file);
  }

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64)");
  curl_setopt($ch, CURLOPT_TIMEOUT, 15);
  $konten = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($konten && $http_code == 200) {
    if (preg_match('/<meta property="og:image" content="([^"]+)"/i', $konten, $m)) return $m[1];
    if (preg_match('/<meta name="twitter:image" content="([^"]+)"/i', $konten, $m)) return $m[1];
    if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $konten, $m)) {
      $img = $m[1];
      if (strpos($img, 'http') !== 0) {
        $p = parse_url($url);
        $img = $p['scheme'] . '://' . $p['host'] . '/' . ltrim($img, '/');
      }
      return $img;
    }
  }
  return 'pict/default.jpg';
}

function getSumberBerita($url)
{
  $parsed = parse_url($url);
  $host = str_replace('www.', '', $parsed['host'] ?? '');
  $parts = explode('.', $host);
  return count($parts) >= 2
    ? ucfirst($parts[count($parts) - 2]) . '.' . $parts[count($parts) - 1]
    : ucfirst($host);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Berita | INOVASIKATAKARSA.ID</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
       /* === RESET & DASAR === */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(-45deg, #fff9e6, #fffbf0, #fef3c7, #fef9e7);
      background-size: 400% 400%;
      animation: gradientShift 15s ease infinite;
      color: #222;
      line-height: 1.6;
      padding-top: 90px;
      position: relative;
      min-height: 100vh;
      overflow-x: hidden;
    }

    @keyframes gradientShift {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    /* Floating particles effect */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image:
        radial-gradient(circle at 20% 30%, rgba(253, 224, 71, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(251, 191, 36, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 80%, rgba(255, 237, 160, 0.12) 0%, transparent 50%);
      pointer-events: none;
      z-index: 0;
      animation: floatingParticles 20s ease-in-out infinite;
    }

    @keyframes floatingParticles {

      0%,
      100% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }

      50% {
        opacity: 0.8;
        transform: translateY(-20px) scale(1.1);
      }
    }

    /* === ANIMASI BINTANG JATUH === */
    .shooting-stars {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0;
    }

    .star {
      position: absolute;
      width: 2px;
      height: 2px;
      background: #fbbf24;
      border-radius: 50%;
      box-shadow: 0 0 10px #fbbf24;
      animation: shootingStar 3s linear infinite;
    }

    .star:nth-child(1) {
      top: 10%;
      left: 20%;
      animation-delay: 0s;
    }

    .star:nth-child(2) {
      top: 30%;
      left: 60%;
      animation-delay: 1s;
    }

    .star:nth-child(3) {
      top: 50%;
      left: 80%;
      animation-delay: 2s;
    }

    .star:nth-child(4) {
      top: 70%;
      left: 40%;
      animation-delay: 1.5s;
    }

    .star:nth-child(5) {
      top: 20%;
      left: 90%;
      animation-delay: 0.5s;
    }

    @keyframes shootingStar {
      0% {
        transform: translateX(0) translateY(0) rotate(45deg);
        opacity: 1;
      }

      70% {
        opacity: 1;
      }

      100% {
        transform: translateX(-500px) translateY(500px) rotate(45deg);
        opacity: 0;
      }
    }

    /* === ANIMASI GELEMBUNG === */
    .bubbles {
      position: fixed;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      pointer-events: none;
      z-index: 0;
      overflow: hidden;
    }

    .bubble {
      position: absolute;
      bottom: -100px;
      background: rgba(253, 224, 71, 0.3);
      border-radius: 50%;
      animation: rise 15s infinite ease-in;
      box-shadow: 0 0 20px rgba(251, 191, 36, 0.2);
    }

    .bubble:nth-child(1) {
      width: 40px;
      height: 40px;
      left: 10%;
      animation-delay: 0s;
      animation-duration: 12s;
    }

    .bubble:nth-child(2) {
      width: 20px;
      height: 20px;
      left: 20%;
      animation-delay: 2s;
      animation-duration: 14s;
    }

    .bubble:nth-child(3) {
      width: 50px;
      height: 50px;
      left: 35%;
      animation-delay: 4s;
      animation-duration: 16s;
    }

    .bubble:nth-child(4) {
      width: 30px;
      height: 30px;
      left: 50%;
      animation-delay: 0s;
      animation-duration: 13s;
    }

    .bubble:nth-child(5) {
      width: 25px;
      height: 25px;
      left: 55%;
      animation-delay: 1s;
      animation-duration: 15s;
    }

    .bubble:nth-child(6) {
      width: 35px;
      height: 35px;
      left: 65%;
      animation-delay: 3s;
      animation-duration: 17s;
    }

    .bubble:nth-child(7) {
      width: 45px;
      height: 45px;
      left: 80%;
      animation-delay: 5s;
      animation-duration: 14s;
    }

    .bubble:nth-child(8) {
      width: 28px;
      height: 28px;
      left: 90%;
      animation-delay: 2s;
      animation-duration: 12s;
    }

    @keyframes rise {
      0% {
        bottom: -100px;
        transform: translateX(0) scale(1);
        opacity: 0;
      }

      10% {
        opacity: 0.6;
      }

      90% {
        opacity: 0.6;
      }

      100% {
        bottom: 110vh;
        transform: translateX(100px) scale(0.5);
        opacity: 0;
      }
    }

    /* === ANIMASI KONFETI === */
    .confetti {
      position: fixed;
      width: 10px;
      height: 10px;
      top: -10px;
      z-index: 0;
      pointer-events: none;
      animation: confettiFall 8s linear infinite;
    }

    .confetti:nth-child(odd) {
      background: #fbbf24;
    }

    .confetti:nth-child(even) {
      background: #fde047;
    }

    .confetti:nth-child(1) {
      left: 5%;
      animation-delay: 0s;
    }

    .confetti:nth-child(2) {
      left: 15%;
      animation-delay: 1s;
    }

    .confetti:nth-child(3) {
      left: 25%;
      animation-delay: 2s;
    }

    .confetti:nth-child(4) {
      left: 35%;
      animation-delay: 0.5s;
    }

    .confetti:nth-child(5) {
      left: 45%;
      animation-delay: 1.5s;
    }

    .confetti:nth-child(6) {
      left: 55%;
      animation-delay: 2.5s;
    }

    .confetti:nth-child(7) {
      left: 65%;
      animation-delay: 1s;
    }

    .confetti:nth-child(8) {
      left: 75%;
      animation-delay: 0.3s;
    }

    .confetti:nth-child(9) {
      left: 85%;
      animation-delay: 1.8s;
    }

    .confetti:nth-child(10) {
      left: 95%;
      animation-delay: 2.2s;
    }

    @keyframes confettiFall {
      0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
      }

      100% {
        transform: translateY(100vh) rotate(720deg);
        opacity: 0;
      }
    }

    /* Floating decorative elements */
    .floating-emoji {
      position: fixed;
      font-size: 40px;
      opacity: 0.12;
      animation: floatRandom 15s infinite ease-in-out;
      pointer-events: none;
      z-index: 0;
    }

    .floating-emoji:nth-child(1) {
      top: 10%;
      left: 5%;
      animation-delay: 0s;
    }

    .floating-emoji:nth-child(2) {
      top: 20%;
      right: 8%;
      animation-delay: 2s;
    }

    .floating-emoji:nth-child(3) {
      top: 60%;
      left: 3%;
      animation-delay: 4s;
    }

    .floating-emoji:nth-child(4) {
      top: 75%;
      right: 5%;
      animation-delay: 6s;
    }

    @keyframes floatRandom {

      0%,
      100% {
        transform: translate(0, 0) rotate(0deg);
      }

      25% {
        transform: translate(20px, -20px) rotate(5deg);
      }

      50% {
        transform: translate(-15px, -30px) rotate(-5deg);
      }

      75% {
        transform: translate(15px, -15px) rotate(3deg);
      }
    }

    /* === ANIMASI KATA-KATA INSPIRATIF KARSA === */
    .inspirational-words {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 80vh;
      /* hanya sampai 80% layar, tidak sampai footer */
      pointer-events: none;
      overflow: hidden;
      z-index: 0;
    }

    .word-float {
      position: absolute;
      font-family: 'Caveat Brush', cursive;
      font-weight: 600;
      color: rgba(251, 191, 36, 0.35);
      text-shadow: 2px 2px 8px rgba(253, 224, 71, 0.3);
      white-space: nowrap;
      font-size: 1.8rem;
      /* ukuran standar desktop */
      animation: wordAnimation 10s infinite ease-in-out;
    }

    /* Posisi tiap kata */
    .word-float:nth-child(1) {
      top: 15%;
      left: 10%;
      animation-delay: 0s;
    }

    .word-float:nth-child(2) {
      top: 25%;
      right: 15%;
      animation-delay: 1.5s;
    }

    .word-float:nth-child(3) {
      top: 45%;
      left: 5%;
      animation-delay: 3s;
    }

    .word-float:nth-child(4) {
      top: 55%;
      right: 8%;
      animation-delay: 4.5s;
    }

    .word-float:nth-child(5) {
      top: 70%;
      left: 12%;
      animation-delay: 6s;
    }

    .word-float:nth-child(6) {
      top: 80%;
      right: 20%;
      animation-delay: 7.5s;
    }

    /* Animasi utama */
    @keyframes wordAnimation {
      0% {
        opacity: 0;
        transform: translateX(-50%) translateY(0) rotate(-5deg) scale(0.7);
      }

      20% {
        opacity: 0.7;
        transform: translateX(0) translateY(-10px) rotate(2deg) scale(1);
      }

      50% {
        opacity: 0.8;
        transform: translateX(10px) translateY(-20px) rotate(-2deg) scale(1.05);
      }

      80% {
        opacity: 0.6;
        transform: translateX(20px) translateY(-30px) rotate(1deg) scale(1);
      }

      100% {
        opacity: 0;
        transform: translateX(80%) translateY(-40px) rotate(8deg) scale(0.6);
      }
    }

    /* Responsif untuk tablet dan HP */
    @media (max-width: 1024px) {
      .word-float {
        font-size: 1.6rem;
      }
    }

    @media (max-width: 768px) {
      .word-float {
        font-size: 1.4rem;
      }
    }

    @media (max-width: 480px) {
      .word-float {
        font-size: 1.2rem;
      }
    }

    h1,
    h2,
    h3 {
      font-family: 'Caveat Brush', cursive;
      letter-spacing: 1px;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    /* === GRID WRAPPER === */
    .berita {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
      padding: 0 8% 60px 8%;
      justify-content: center; /* Card otomatis ke tengah */
    }


    /* === CARD === */
   .news-card {
      background: linear-gradient(135deg, #fffef7, #fff6d6);
      border-radius: 16px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transform: translateY(30px);
      opacity: 0;
      transition: transform 0.8s ease, opacity 0.8s ease, box-shadow 0.3s ease;
      width: calc(33.333% - 17px); /* 3 kolom otomatis */
      min-width: 290px; /* Minimal lebar card */
      max-width: 400px; /* Maksimal lebar card */
    }
    /* Responsive */
    @media (max-width: 1200px) {
      .news-card {
        width: calc(50% - 13px); /* 2 kolom di tablet */
      }
    }

    @media (max-width: 768px) {
      .news-card {
        width: 100%; /* 1 kolom di mobile */
        max-width: 100%;
      }
    }

    .news-card.in-view {
      transform: translateY(0);
      opacity: 1;
      box-shadow: 0 8px 22px rgba(0, 0, 0, 0.15); /* bayangan lebih jelas saat tampil */
    }

    .news-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.18);
    }


    .news-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .news-card:hover img {
      transform: scale(1.05);
    }

    .news-content {
      padding: 18px;
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .news-content h2 {
      font-size: 1.1rem;
      color: #111;
      margin-bottom: 8px;
    }

    .news-source {
      font-size: 0.9rem;
      color: #777;
      margin-bottom: 8px;
    }

    .news-source::before {
      content: "📰 ";
    }

    .detail-btn {
      align-self: flex-start;
      background: linear-gradient(135deg, #fdd835, #ffb300);
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 8px 16px;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.25s ease;
    }

    .detail-btn:hover {
      background: #0d2a8a;
      transform: translateY(-2px);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      h1 {
        font-size: 1.8rem;
      }
      .berita {
        padding: 0 5% 40px 5%;
        gap: 20px;
      }
    }

    @media (max-width: 480px) {
      .news-card img {
        height: 150px;
      }
    }

   .judul-berita {
      color: #fbbf24;
      font-size: 2.5em;
      text-align: center;
      width: 100%;
      display: block;
      letter-spacing: 1px;
      margin: 40px 0 20px 0;
      opacity: 0;
      transform: translateY(-40px); /* dari atas turun */
      animation: fadeSlideDown 1.5s ease-out forwards;
    }

    @keyframes fadeSlideDown {
      0% {
        opacity: 0;
        transform: translateY(-40px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }



    
  </style>
</head>

<body>
  <!-- Animasi Bintang Jatuh -->
  <div class="shooting-stars">
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
  </div>

  <!-- Animasi Gelembung -->
  <div class="bubbles">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
  </div>

  <!-- Animasi Konfeti -->
  <div class="confetti"></div>
  <div class="confetti"></div>
  <div class="confetti"></div>
  <div class="confetti"></div>
  <div class="confetti"></div>
  <div class="confetti"></div>
  <div class="confetti"></div>
  <div class="confetti"></div>
  <div class="confetti"></div>
  <div class="confetti"></div>

  <!-- Floating Decorative Elements -->
  <div class="floating-emoji">📖</div>
  <div class="floating-emoji">✏️</div>
  <div class="floating-emoji">🎨</div>
  <div class="floating-emoji">💡</div>

  <!-- Kata-Kata Inspiratif Karsa -->
  <div class="inspirational-words">
    <div class="word-float">Karsa Mengubah Dunia</div>
    <div class="word-float">Berani Bermimpi</div>
    <div class="word-float">Tekad Membawa Perubahan</div>
    <div class="word-float">Niat Mulia Berbuah Karya</div>
    <div class="word-float">Bersama Kita Bisa</div>
    <div class="word-float">Inovasi Dimulai Dari Hati</div>
  </div>
<h1 class="judul-berita">
  BERITA SEPUTAR PIKK
</h1><BR>


  <div class="berita">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <?php
        $url = htmlspecialchars($row['link_berita']);
        $thumbnail = ambilGambar($url);
        $sumber = getSumberBerita($url);
        ?>
        <div class="news-card reveal">
          <img src="<?= htmlspecialchars($thumbnail) ?>" alt="Thumbnail Berita" onerror="this.src='pict/default.jpg'">
          <div class="news-content">
            <div>
              <h2><?= htmlspecialchars($row['judul']) ?></h2>
              <div class="news-source"><?= htmlspecialchars($sumber) ?></div>
            </div>
            <a href="<?= $url ?>" target="_blank" class="detail-btn">Baca Selengkapnya</a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align:center;">Belum ada berita.</p>
    <?php endif; ?>
  </div>

  <?php include 'footer.php'; ?>

  <script>
    // Efek muncul smooth saat scroll
    (function() {
      const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
          if (e.isIntersecting) {
            e.target.classList.add('in-view');
            io.unobserve(e.target);
          }
        });
      }, { threshold: 0.1 });
      document.querySelectorAll('.news-card').forEach(el => io.observe(el));
    })();
  </script>
</body>
</html>
