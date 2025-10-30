<?php
// index.php
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PIKK - Home</title>

  <!-- ===== GOOGLE FONT (Caveat Brush) ===== -->
  <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    /* ===== RESET & DASAR ===== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #f3f3f3;
      color: #222;
      line-height: 1.6;
      padding-top: 90px;
      /* biar gak ketutup navbar */
    }

    h1,
    h2,
    h3 {
      font-family: 'Caveat Brush', cursive;
      letter-spacing: 1px;
      font-size: 1.8em;
    }


    /* ===== FOOTER ===== */
    footer {
      background: #FFDE59;
      padding: 40px 10%;
      color: #222;
      margin-top: 60px;
      display: flex;
      flex-direction: column;
      align-items: center;
      /* isi footer di tengah horizontal */
      text-align: center;
      /* teks di tengah */
      position: relative;
      z-index: 10;
    }

    .footer-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      /* posisikan konten di tengah */
      gap: 25px;
      max-width: 1000px;
      /* biar tidak terlalu lebar di layar besar */
    }

    .footer-container div {
      flex: 1;
      min-width: 260px;
    }

    .footer-container h4 {
      margin-bottom: 10px;
    }

    iframe {
      width: 100%;
      height: 200px;
      border: 0;
      border-radius: 10px;
    }

    .social-icons img {
      width: 28px;
      margin-right: 10px;
      transition: transform 0.3s ease;
    }

    .social-icons img:hover {
      transform: scale(1.2);
    }

    .footer-copy {
      text-align: center;
      margin-top: 25px;
      font-size: 0.9em;
      font-weight: bold;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
      .hero-text h1 {
        font-size: 2.5em;
      }

      .hero-text p {
        font-size: 1.1em;
      }
    }

    @media (max-width: 768px) {
      .nav-links {
        display: none;
        /* nanti bisa ganti ke menu burger kalau mau */
      }

      .hero {
        height: 70vh;
      }

      .hero-text h1 {
        font-size: 2em;
        line-height: 1.3;
      }

      .hero-text p {
        font-size: 1em;
      }

      .tentang {
        width: 90%;
        padding: 30px 20px;
      }

      .footer-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .footer-container div {
        width: 100%;
      }

      iframe {
        height: 180px;
      }

      .cards {
        grid-template-columns: 1fr;
        width: 90%;
      }

      .card-row {
        flex-direction: column;
        align-items: center;
      }
    }

    @media (max-width: 480px) {
      .hero {
        height: 65vh;
      }

      .hero-text h1 {
        font-size: 1.7em;
      }

      .hero-text p {
        font-size: 0.95em;
      }

      .tentang h2,
      .aktivitas h2 {
        font-size: 1.6em;
      }
    }
  </style>

  </style>
</head>

<body>


  <footer>
    <div class="footer-container">
      <div>
        <h3 style="font-family: 'Caveat Brush', cursive; color: #ffffffff;">Lokasi Kami</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.8161546549563!2d109.2994145!3d-0.0596979!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e1d59003acdbe8b%3A0xd7c5a91177e58e44!2sSEKRETARIAT%20PERKUMPULAN%20INOVASI%20KATA%20KARSA!5e0!3m2!1sid!2sid!4v1760414651769!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

      <div>
        <h3 style="font-family: 'Caveat Brush', cursive; color: #ffffffff;">Kontak Kami</h3>
        <p>perkumpulaninovasikatakarsa@gmail.com<br />0895-3377-12591<br />Jl. Karya Sosial, Pal IX, Kec.Sungai Kakap, Kab.Kubu Raya, Kalimantan Barat</p>
      </div>

      <div>
        <h3 style="font-family: 'Caveat Brush', cursive; color: #ffffffff;">Social Media</h3>
        <div class="social-icons">
          <a href="mailto:perkumpulaninovasikatakarsa@gmail.com"><img src="logo/gmail.png" alt="Gmail" /></a>
          <a href="https://www.instagram.com/inovasikatakarsa.id?igsh=Mmg4NnAxYzZmMzV6"><img src="logo/instagram.png" alt="Instagram" /></a>
          <a href="https://www.linkedin.com/in/perkumpulan-inovasi-kata-karsa?fbclid=PAZXh0bgNhZW0CMTEAAaeYs5aGpfZrljgoVEdzY0QO5GBX_kRM8HmmdUUonQ5ZGJnnnwI-lCpI94jDzw_aem_BW69HARiwqM_yayETVkvUQ"><img src="logo/linkedin.png" alt="linkedin" /></a>
          <a href="https://api.whatsapp.com/send?phone=62895337712591"><img src="logo/whatsapp.png" alt="whatsapp" /></a>
        </div>
      </div>
    </div>
    <p class="footer-copy">©<?php echo date("Y"); ?> SEMUA HAK CIPTA DILINDUNGI | INOVASIKATAKARSA.ID
    </p>
  </footer>

  <script>
    console.log("✅ PIKK Homepage Loaded with PHP");
  </script>
</body>

</html>