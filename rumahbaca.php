<?php
include 'header.php';
include 'admin/config/conn_db.php';

// Ambil data dari tabel teras_baca_settings
$result = mysqli_query($conn, "SELECT * FROM teras_baca_settings WHERE id = 1");

// Buat nilai default supaya tidak error meski tabel kosong
$teras = [
  'jumlah_buku' => 0,
  'alamat' => 'Belum diatur',
  'link_maps' => '#',
  'nomor_wa' => '6281234567890',
  'pesan_wa' => 'Halo! Saya ingin mendonasikan buku untuk Teras Baca.'
];

// Jika query berhasil dan ada hasil, ambil datanya
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $teras = array_merge($teras, $row);
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Program Kami | Teras Baca | INOVASIKATAKARSA.ID</title>

  <!-- ===== FONT ===== -->
  <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

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

    /* Main Content */
    main {
      max-width: 1000px;
      margin: 30px auto;
      padding: 20px 40px;
      position: relative;
      z-index: 1;
    }

    h1 {
      text-align: center;
      font-size: 2.5em;
      color: #fbbf24;
      margin-bottom: 30px;
      text-shadow: 3px 3px 6px rgba(251, 191, 36, 0.3);
      animation: fadeInDown 0.8s ease;
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Tabs */
    .tabs {
      display: flex;
      justify-content: center;
      gap: 18px;
      margin-bottom: 40px;
      animation: fadeInUp 0.8s ease 0.2s both;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .tab {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      padding: 12px 30px;
      border-radius: 10px;
      border: 2px solid rgba(253, 216, 53, 0.2);
      cursor: pointer;
      font-weight: 700;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      color: #222;
    }

    .tab:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(253, 216, 53, 0.3);
    }

    .tab.active {
      background: linear-gradient(135deg, #fdd835, #ffb300);
      color: white;
      border-color: #ffb300;
      box-shadow: 0 5px 15px rgba(253, 216, 53, 0.4);
    }

    /* Section Header */
    .section-header {
      text-align: center;
      margin-bottom: 40px;
      animation: fadeInScale 0.6s ease-out 0.3s both;
    }

    @keyframes fadeInScale {
      from {
        opacity: 0;
        transform: scale(0.95) translateY(20px);
      }

      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }

    .section-header h2 {
      font-size: 2em;
      color: #333;
      margin-bottom: 8px;
    }

    .section-header p {
      color: #666;
      font-size: 1.05em;
    }

    /* Content Section */
    .content-section {
      background: rgba(255, 251, 234, 0.95);
      backdrop-filter: blur(10px);
      border-left: 5px solid #fdd835;
      border-radius: 15px;
      padding: 30px;
      margin-bottom: 30px;
      box-shadow: 0 5px 15px rgba(253, 216, 53, 0.2);
      transition: all 0.4s ease;
      animation: fadeInScale 0.6s ease-out backwards;
    }

    .content-section:nth-child(1) {
      animation-delay: 0.4s;
    }

    .content-section:nth-child(2) {
      animation-delay: 0.5s;
    }

    .content-section:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(253, 216, 53, 0.3);
    }

    .content-section h3 {
      font-size: 1.5em;
      color: #333;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .content-section p {
      color: #555;
      line-height: 1.8;
      margin-bottom: 12px;
      text-align: justify;
    }

    .content-section ul {
      list-style: none;
      padding-left: 0;
      margin: 15px 0;
    }

    .content-section ul li {
      color: #555;
      line-height: 1.8;
      margin-bottom: 8px;
      padding-left: 25px;
      position: relative;
    }

    .content-section ul li::before {
      content: '✓';
      position: absolute;
      left: 0;
      color: #fdd835;
      font-weight: bold;
      font-size: 1.2em;
    }

    .stats-button {
      background: linear-gradient(135deg, #fdd835, #ffb300);
      color: white;
      padding: 12px 30px;
      border-radius: 10px;
      border: none;
      font-weight: 700;
      font-size: 1em;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin: 15px auto 0;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(253, 216, 53, 0.3);
      width: fit-content;
    }

    .stats-button:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 6px 20px rgba(253, 216, 53, 0.5);
    }

    .quote {
      font-style: italic;
      color: #666;
      text-align: center;
      padding: 20px;
      margin: 20px 0;
      border-left: 3px solid #fdd835;
      background: rgba(253, 216, 53, 0.05);
      border-radius: 8px;
    }

    .cta-button {
      background: linear-gradient(135deg, #fdd835, #ffb300);
      color: white;
      padding: 15px 35px;
      border-radius: 10px;
      border: none;
      font-weight: 700;
      font-size: 1.1em;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(253, 216, 53, 0.3);
      text-decoration: none;
      display: inline-block;
    }

    .cta-button:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 6px 20px rgba(253, 216, 53, 0.5);
    }

    .cta-wrap {
      text-align: center;
      margin-top: 20px;
    }

    /* Gallery Section */
    .gallery-section {
      margin-top: 50px;
      text-align: center;
      animation: fadeInScale 0.6s ease-out 0.6s both;
    }

    .gallery-section h2 {
      font-size: 1.8em;
      color: #333;
      margin-bottom: 20px;
    }

    .gallery-placeholder {
      color: #999;
      font-size: 1em;
      font-style: italic;
      padding: 30px;
      margin-top: 20px;
      background: rgba(250, 250, 250, 0.8);
      border-radius: 10px;
      border: 2px dashed #ddd;
    }

    /* Responsive */
    @media (max-width: 768px) {
      body {
        padding-top: 70px;
      }

      main {
        padding: 20px;
      }

      h1 {
        font-size: 2em;
      }

      .tabs {
        flex-wrap: wrap;
        gap: 12px;
      }

      .tab {
        padding: 10px 20px;
        font-size: 0.85rem;
      }

      .content-section {
        padding: 20px;
      }

      .floating-emoji {
        display: none;
      }
    }

    @media (max-width: 480px) {
      body {
        padding-top: 60px;
      }

      main {
        padding: 15px;
      }

      h1 {
        font-size: 1.8em;
      }

      .content-section {
        padding: 20px;
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
  <div class="floating-emoji">📚</div>
  <div class="floating-emoji">✨</div>
  <div class="floating-emoji">🌟</div>
  <div class="floating-emoji">🎈</div>

  <!-- Kata-Kata Inspiratif Karsa -->
  <div class="inspirational-words">
    <div class="word-float">Karsa Mengubah Dunia</div>
    <div class="word-float">Berani Bermimpi</div>
    <div class="word-float">Tekad Membawa Perubahan</div>
    <div class="word-float">Niat Mulia Berbuah Karya</div>
    <div class="word-float">Bersama Kita Bisa</div>
    <div class="word-float">Inovasi Dimulai Dari Hati</div>
  </div>



  <main>
    <h1 style="color: #fbbf24; font-size: 2.5em;">PROGRAM KAMI</h1>

    <div class="tabs">
      <a class="tab" href="kegiatan.php">PIKK</a>
      <a class="tab" href="kolaborasi.php">Kolaborasi</a>
      <span class="tab active">Teras Baca</span>
    </div>

    <!-- Tentang Teras Baca -->
    <div class="content-section">
      <h3>📚 Tentang Teras Baca PIKK</h3>
      <p>
        Teras Baca PIKK merupakan ruang bersama berbasis bagi siapapun yang ingin meningkatkan kemampuan dan memperluas minat membaca.
      </p>
      <p>
        Kami percaya bahwa membaca adalah jendela dunia bagi generasi muda masa depan yang tak terbatas oleh literasi. Teras Baca hadir untuk memudahkan warga lokal agar semakin mencintai buku dan menghargai pengetahuan.
      </p>

      <button class="stats-button">
        📊 Jumlah Buku Saat ini: <?= number_format($teras['jumlah_buku']); ?> Buku
      </button>
    </div>

    <!-- Ayo Datang dan Membaca -->
    <div class="content-section">
      <h3>📚 Ayo Datang dan Membaca!</h3>
      <p>
        Mari bergabung! Teras Baca kami terbuka untuk umum — pelajar, masyarakat, dan siapa saja yang ingin memperluas wawasan. Semua gratis dan terbuka untuk semua kalangan!
      </p>

      <p><strong>✅ Lokasi:</strong> <?= htmlspecialchars($teras['alamat']); ?></p>

      <div class="quote">
        "Satu buku membuka seribu pikiran – jadilah bagian dari gerakan membaca!"
      </div>

      <div class="cta-wrap">
        <a href="<?= htmlspecialchars($teras['link_maps']); ?>"
          target="_blank" rel="noopener noreferrer" class="cta-button" style="margin: 10px;">
          📍 Kunjungi Sekarang
        </a>
      </div>

      <h4 style="margin-top: 25px;">🎁 Dukung Kami dengan Donasi Buku!</h4>
      <p>
        Kamu bisa ikut berkontribusi dengan mendonasikan buku bacaan baru atau bekas layak baca.
        Setiap buku yang kamu berikan akan membantu menambah wawasan banyak orang!
      </p>

      <div class="cta-wrap">
        <a href="https://wa.me/<?= htmlspecialchars($teras['nomor_wa']); ?>?text=<?= urlencode($teras['pesan_wa']); ?>"
          target="_blank" rel="noopener noreferrer" class="cta-button" style="background-color: #25D366; margin: 10px;">
          💬 Hubungi via WhatsApp
        </a>
      </div>
    </div>
  </main>

  <?php include 'footer.php'; ?>
</body>

</html>