<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PIKK - Home</title>

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

    /* === HERO === */
    .hero {
      position: relative;
      width: 100%;
      height: 60vh;
      min-height: 400px;
      max-height: 600px;
      overflow: hidden;
      z-index: 1;
    }

    .hero img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      animation: zoomInOut 20s ease-in-out infinite;
    }

    @keyframes zoomInOut {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.05);
      }
    }

    .hero::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.55);
      z-index: 1;
    }

    .hero-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      text-align: center;
      text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6);
      z-index: 2;
      width: 90%;
      max-width: 900px;
      padding: 0 20px;
      animation: fadeInUp 1s ease-out;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translate(-50%, -40%);
      }

      to {
        opacity: 1;
        transform: translate(-50%, -50%);
      }
    }

    .hero-text h1 {
      font-size: clamp(1.5rem, 5vw, 3rem);
      margin-bottom: 1rem;
      line-height: 1.3;
      animation: bounceIn 1.2s ease-out;
    }

    @keyframes bounceIn {
      0% {
        transform: scale(0.5);
        opacity: 0;
      }

      60% {
        transform: scale(1.1);
        opacity: 1;
      }

      100% {
        transform: scale(1);
      }
    }

    .hero-text p {
      font-size: clamp(0.9rem, 2.5vw, 1.1rem);
      line-height: 1.6;
      animation: fadeIn 1.5s ease-out 0.3s both;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    /* === TENTANG === */
    .tentang {
      background: linear-gradient(135deg, #fffaf0, #fff6da);
      backdrop-filter: blur(10px);
      margin: 60px auto;
      width: 90%;
      max-width: 1000px;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(253, 216, 53, 0.3), 0 0 0 2px rgba(253, 216, 53, 0.2);
      text-align: center;
      position: relative;
      z-index: 1;
      animation: slideInUp 0.8s ease-out;
    }

    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(50px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .tentang h2 {
      margin-bottom: 15px;
      font-size: clamp(1.5rem, 4vw, 2rem);
      color: #fbbf24;
      animation: wiggle 2s ease-in-out infinite;
    }

    @keyframes wiggle {

      0%,
      100% {
        transform: rotate(0deg);
      }

      25% {
        transform: rotate(2deg);
      }

      75% {
        transform: rotate(-2deg);
      }
    }

    .tentang p {
      margin-bottom: 20px;
      color: #444;
      font-size: clamp(0.9rem, 2vw, 1rem);
      line-height: 1.7;
    }

    .tentang button {
      background: linear-gradient(135deg, #fdd835, #ffb300);
      border: none;
      padding: 12px 28px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
      font-size: 1rem;
      box-shadow: 0 4px 10px rgba(253, 216, 53, 0.4);
      transition: all 0.3s ease;
      animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.05);
      }
    }

    .tentang button:hover {
      transform: scale(1.1) rotate(-2deg);
      box-shadow: 0 6px 15px rgba(253, 216, 53, 0.5);
      animation: none;
    }

    /* === KARTU KEGIATAN - SELALU 4 KOLOM === */
    .cards {
      display: grid;
      grid-template-columns: repeat(4, 1fr) !important;
      gap: 25px;
      margin: 60px auto;
      width: 90%;
      max-width: 1100px;
      position: relative;
      z-index: 1;
    }

    .card {
      background: linear-gradient(135deg, #fffaf0, #fff6da);
      backdrop-filter: blur(10px);
      padding: 30px 20px;
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 100%;
      transition: all 0.4s ease;
      animation: fadeInScale 0.6s ease-out backwards;

    }

    @keyframes fadeInScale {
      from {
        opacity: 0;
        transform: scale(0.8);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .card:nth-child(1) {
      animation-delay: 0.1s;
    }

    .card:nth-child(2) {
      animation-delay: 0.2s;
    }

    .card:nth-child(3) {
      animation-delay: 0.3s;
    }

    .card:nth-child(4) {
      animation-delay: 0.4s;
    }

    .card:hover {
      transform: translateY(-15px) rotate(2deg);
      box-shadow: 0 12px 25px rgba(253, 216, 53, 0.5);
      background: rgba(255, 255, 255, 1);
    }

    .card h3 {
      color: #fbbf24;
      margin-bottom: 10px;
      font-size: 1.3rem;
    }

    .card:hover h3 {
      animation: shake 0.5s ease;
    }

    @keyframes shake {

      0%,
      100% {
        transform: translateX(0);
      }

      25% {
        transform: translateX(-5px);
      }

      75% {
        transform: translateX(5px);
      }
    }

    .card p {
      color: #444;
      font-size: 0.95rem;
      line-height: 1.8;
      text-align: center;
    }

    /* === AKTIVITAS - SELALU 3 KOLOM === */
    .aktivitas {
      text-align: center;
      margin-top: 70px;
      margin-bottom: 60px;
      width: 90%;
      max-width: 1100px;
      margin-inline: auto;
      position: relative;
      z-index: 1;
    }

    .aktivitas h2 {
      margin-bottom: 25px;
      font-size: clamp(1.5rem, 4vw, 2rem);
      color: #fbbf24;
      animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-10px);
      }
    }

    .card-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr) !important;
      gap: 25px;
    }

    .card-row .card {
      animation-delay: 0.5s;
    }

    .card-row .card:nth-child(2) {
      animation-delay: 0.6s;
    }

    .card-row .card:nth-child(3) {
      animation-delay: 0.7s;
    }

    .card-row .card button {
      background: linear-gradient(135deg, #fdd835, #ffb300);
      border: none;
      padding: 10px 18px;
      border-radius: 10px;
      margin-top: 15px;
      cursor: pointer;
      font-weight: bold;
      font-size: 0.9rem;
      box-shadow: 0 3px 8px rgba(253, 216, 53, 0.3);
      transition: all 0.3s ease;
    }

    .card-row .card button:hover {
      transform: scale(1.15) rotate(-3deg);
      box-shadow: 0 8px 16px rgba(253, 216, 53, 0.5);
      animation: wiggleButton 0.5s ease;
    }

    @keyframes wiggleButton {

      0%,
      100% {
        transform: scale(1.15) rotate(-3deg);
      }

      25% {
        transform: scale(1.15) rotate(-5deg);
      }

      75% {
        transform: scale(1.15) rotate(-1deg);
      }
    }

    /* Responsive kata inspiratif */
    @media (max-width: 768px) {
      .word-float {
        font-size: 1.5rem !important;
      }

      .word-float:nth-child(1) {
        font-size: 1.8rem !important;
      }

      .word-float:nth-child(3) {
        font-size: 2rem !important;
      }

      .word-float:nth-child(5) {
        font-size: 1.9rem !important;
      }
    }

    @media (max-width: 480px) {
      .word-float {
        font-size: 1.2rem !important;
      }

      .word-float:nth-child(1) {
        font-size: 1.5rem !important;
      }

      .word-float:nth-child(3) {
        font-size: 1.6rem !important;
      }

      .word-float:nth-child(5) {
        font-size: 1.5rem !important;
      }
    }

    /* === RESPONSIVE - TETAP 4 & 3 KOLOM === */

    /* Tablet */
    @media (max-width: 1024px) and (min-width: 769px) {
      body {
        padding-top: 80px;
      }

      .hero {
        height: 50vh;
        min-height: 350px;
        max-height: 500px;
      }

      .tentang {
        padding: 35px 25px;
        margin: 50px auto;
      }

      .cards {
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 15px;
      }

      .card {
        padding: 20px 12px;
      }

      .card h3 {
        font-size: 1rem;
      }

      .card p {
        font-size: 0.8rem;
        line-height: 1.7;
        text-align: center;
      }

      .card-row {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 15px;
      }
    }

    /* Mobile Large */
    @media (max-width: 768px) {
      body {
        padding-top: 70px;
      }

      .hero {
        height: 45vh;
        min-height: 320px;
        max-height: 450px;
      }

      .hero-text h1 br {
        display: none;
      }

      .tentang {
        width: 95%;
        padding: 30px 20px;
        margin: 40px auto;
      }

      .cards {
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 10px;
        width: 98%;
      }

      .card {
        padding: 15px 8px;
      }

      .card h3 {
        font-size: 0.85rem;
      }

      .card p {
        font-size: 0.7rem;
        line-height: 1.6;
        text-align: center;
      }

      .aktivitas {
        margin-top: 50px;
        width: 98%;
      }

      .card-row {
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
      }

      .card-row .card button {
        padding: 7px 10px;
        font-size: 0.75rem;
      }

      .floating-emoji {
        display: none;
      }
    }

    /* Mobile Small */
    @media (max-width: 480px) {
      body {
        padding-top: 60px;
      }

      .hero {
        height: 40vh;
        min-height: 280px;
        max-height: 380px;
      }

      .tentang {
        padding: 25px 15px;
        margin: 30px auto;
      }

      .tentang button {
        padding: 10px 20px;
        font-size: 0.85rem;
      }

      .cards {
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        width: 100%;
        padding: 0 5px;
      }

      .card {
        padding: 12px 5px;
      }

      .card h3 {
        font-size: 0.75rem;
        margin-bottom: 6px;
      }

      .card p {
        font-size: 0.62rem;
        line-height: 1.5;
        text-align: center;
      }

      .aktivitas {
        margin-top: 40px;
        width: 100%;
        padding: 0 5px;
      }

      .card-row {
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
      }

      .card-row .card button {
        padding: 6px 8px;
        font-size: 0.7rem;
      }
    }

    /* Extra Small */
    @media (max-width: 360px) {
      .hero {
        height: 35vh;
        min-height: 250px;
        max-height: 320px;
      }

      .cards {
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
        padding: 0 3px;
      }

      .card {
        padding: 10px 4px;
      }

      .card h3 {
        font-size: 0.68rem;
        margin-bottom: 4px;
      }

      .card p {
        font-size: 0.58rem;
        line-height: 1.4;
        text-align: center;
      }

      .card-row {
        grid-template-columns: repeat(3, 1fr);
        gap: 6px;
      }

      .card-row .card button {
        padding: 5px 6px;
        font-size: 0.65rem;
      }
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>

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

  <header>
    <section class="hero">
      <img src="pict/home.jpg" alt="home" />
      <div class="hero-text">
        <h1>IDE MENJADI AKSI <br> INOVASI MENJADI PRESTASI!</h1>
        <p>PIKK mengubah gagasan menjadi karya nyata melalui literasi, edukasi, dan aksi sosial. Bersama, kita berinovasi, berkolaborasi, dan memberi dampak positif bagi sesama.</p>
      </div>
    </section>
  </header>

  <main>
    <section class="tentang">
      <h2>Tentang Kami</h2>
      <p>
        Perkumpulan Inovasi Kata Karsa (PIKK) adalah komunitas sosial yang berfokus pada pengembangan literasi, pendidikan, dan potensi kemanusiaan. Kami percaya bahwa kata-kata bisa menumbuhkan harapan serta semangat untuk berinovasi, berkolaborasi, dan berbagi inspirasi bagi sesama.
      </p>
      <button><a href="tentang.php" style="color:white">Baca Selengkapnya</a></button>
    </section>

    <section class="cards">
      <div class="card">
        <h3>Menjalin Relasi</h3>
        <p>Memperluas koneksi dengan individu yang memiliki minat dan visi serupa.</p>
      </div>
      <div class="card">
        <h3>Dukungan Komunitas</h3>
        <p>Lingkungan positif untuk belajar, tumbuh, dan berkontribusi.</p>
      </div>
      <div class="card">
        <h3>Menumbuh Wawasan</h3>
        <p>Meningkatkan pengetahuan dan perspektif melalui berbagai kegiatan.</p>
      </div>
      <div class="card">
        <h3>Meningkatkan Skill</h3>
        <p>Pelatihan dan proyek kolaboratif untuk mengasah kemampuan.</p>
      </div>
    </section>

    <section class="aktivitas">
      <h2>Aktivitas Kami</h2>
      <div class="card-row">
        <div class="card">
          <h3>Workshop Literasi</h3>
          <p>Kegiatan rutin untuk meningkatkan kemampuan menulis dan berpikir kritis.</p>
          <button><a href="kegiatan.php" style="color:white">Selengkapnya</a></button>
        </div>
        <div class="card">
          <h3>Program Sosial</h3>
          <p>Kegiatan berbasis aksi nyata membantu masyarakat sekitar.</p>
          <button><a href="kegiatan.php" style="color:white">Selengkapnya</a></button>
        </div>
        <div class="card">
          <h3>Kolaborasi Sekolah</h3>
          <p>Menjalin kerjasama dengan sekolah dalam proyek literasi & motivasi.</p>
          <button><a href="kegiatan.php" style="color:white">Selengkapnya</a></button>
        </div>
      </div>
    </section>
  </main>

  <?php include 'footer.php'; ?>
</body>

</html>
