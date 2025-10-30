<?php include 'header.php'; ?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap');

  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(-45deg, #fff9e6, #fffbf0, #f3ecd3ff, #fef9e7) !important;
    color: #222;
    line-height: 1.6;
    padding-top: 90px;
    position: relative;
    min-height: 100vh;
    overflow-x: hidden;
    margin: 0;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  main {
    max-width: 1200px;
    margin: 30px auto;
    padding: 20px 40px;
    position: relative;
  }

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

  h1 {
    text-align: center;
    font-family: 'Caveat Brush', cursive;
    font-size: 2.5em;
    color: #fbbf24;
    position: relative;
    z-index: 1;
    margin-bottom: 20px;
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

  .stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 40px 0;
    position: relative;
    z-index: 1;
  }

  .stat-card {
    background: linear-gradient(180deg, #fffefd 0%, #fdfcf9 100%) !important;
    padding: 30px 20px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(253, 216, 53, 0.2);
    transition: all 0.4s ease;
    animation: fadeInUp 0.8s ease;
    position: relative;
    overflow: hidden;
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(253, 216, 53, 0.2), transparent);
    transition: left 0.5s ease;
  }

  .stat-card:hover::before {
    left: 100%;
  }

  .stat-card:hover {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 10px 30px rgba(253, 216, 53, 0.4);
  }

  .stat-icon {
    font-size: 50px;
    margin-bottom: 15px;
    display: block;
    animation: bounce 2s infinite;
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

  .stat-number {
    font-size: 36px;
    font-weight: 700;
    background: linear-gradient(135deg, #fdd835, #ffb300);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
  }

  .stat-label {
    font-size: 14px;
    color: #666;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(40px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .about,
  .visi-content,
  .misi-content {
    background: linear-gradient(135deg, #fff9e6 0%, #fffbf0 100%);
    border-radius: 30px;
    padding: 50px;
    font-size: 16px;
    text-align: justify;
    line-height: 1.9;
    box-shadow: 0 10px 30px rgba(253, 216, 53, 0.2), 0 0 0 1px rgba(253, 216, 53, 0.1);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
  }

  .about {
    display: flex;
    align-items: center;
    gap: 40px;
    margin-top: 30px;
  }

  .about::before {
    content: "📚";
    position: absolute;
    font-size: 150px;
    top: -40px;
    right: -40px;
    opacity: 0.06;
    transform: rotate(-20deg);
    animation: float 4s ease-in-out infinite;
  }

  .about::after {
    content: "✨";
    position: absolute;
    font-size: 80px;
    bottom: -20px;
    left: -20px;
    opacity: 0.08;
    animation: float 5s ease-in-out infinite reverse;
  }

  @keyframes float {

    0%,
    100% {
      transform: translateY(0px) rotate(-2deg);
    }

    50% {
      transform: translateY(-15px) rotate(2deg);
    }
  }

  .about:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(253, 216, 53, 0.3), 0 0 0 2px rgba(253, 216, 53, 0.2);
  }

  .about-image-wrapper {
    position: relative;
    flex-shrink: 0;
  }

  .about-image-wrapper::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(253, 216, 53, 0.3), rgba(255, 179, 0, 0.3));
    border-radius: 20px;
    top: 15px;
    left: 15px;
    z-index: -1;
    transition: all 0.4s ease;
  }

  .about-image-wrapper:hover::before {
    top: 20px;
    left: 20px;
  }

  .about img {
    width: 380px;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.4s ease;
    animation: fadeInLeft 0.8s ease;
    display: block;
  }

  .about img:hover {
    transform: scale(1.03);
  }

  @keyframes fadeInLeft {
    from {
      opacity: 0;
      transform: translateX(-30px);
    }

    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  .about-text {
    flex: 1;
    font-size: 16px;
    text-align: justify;
    color: #333;
    line-height: 1.9;
    animation: fadeInRight 0.8s ease;
    position: relative;
    z-index: 1;
  }

  @keyframes fadeInRight {
    from {
      opacity: 0;
      transform: translateX(30px);
    }

    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  .about-text p {
    margin-bottom: 18px;
    transition: transform 0.3s ease;
    position: relative;
    padding-left: 20px;
  }

  .about-text p::before {
    content: '▸';
    position: absolute;
    left: 0;
    color: #fdd835;
    font-weight: bold;
    transition: transform 0.3s ease;
  }

  .about-text p:hover {
    transform: translateX(8px);
  }

  .about-text p:hover::before {
    transform: translateX(-5px);
  }

  .about-text p b {
    background: linear-gradient(135deg, #fdd835 0%, #ffb300 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 17px;
    font-weight: 700;
    filter: drop-shadow(1px 1px 2px rgba(253, 216, 53, 0.3));
  }

  .section-divider {
    text-align: center;
    margin: 80px 0 60px;
    position: relative;
  }

  .section-divider::before,
  .section-divider::after {
    content: '';
    position: absolute;
    top: 50%;
    width: 35%;
    height: 2px;
    background: linear-gradient(to right, transparent, #fdd835, transparent);
  }

  .section-divider::before {
    left: 0;
  }

  .section-divider::after {
    right: 0;
  }

  .section-divider span {
    background: linear-gradient(135deg, #fdd835, #ffb300);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-family: 'Caveat Brush', cursive;
    font-size: 32px;
    padding: 0 20px;
    position: relative;
    z-index: 1;
    filter: drop-shadow(2px 2px 4px rgba(253, 216, 53, 0.3));
  }

  .visi-misi {
    margin: 60px 0;
    position: relative;
  }

  .visi-item,
  .misi-item {
    display: flex;
    align-items: center;
    gap: 40px;
    margin-bottom: 80px;
    position: relative;
  }

  .visi-item {
    justify-content: flex-start;
  }

  .misi-item {
    justify-content: flex-end;
  }

  .visi-badge,
  .misi-badge {
    font-family: 'Caveat Brush', cursive;
    font-size: 64px;
    min-width: 200px;
    text-align: center;
    position: relative;
    z-index: 2;
    background: linear-gradient(135deg, #fdd835 0%, #ffb300 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    filter: drop-shadow(2px 2px 4px rgba(253, 216, 53, 0.4));
    animation: float 3s ease-in-out infinite;
  }

  .visi-content {
    max-width: 680px;
  }

  .visi-content::before {
    content: "💡";
    position: absolute;
    font-size: 80px;
    top: -20px;
    right: -20px;
    opacity: 0.1;
    transform: rotate(-15deg);
  }

  .misi-content {
    max-width: 680px;
  }

  .misi-content::before {
    content: "🎯";
    position: absolute;
    font-size: 80px;
    top: -20px;
    left: -20px;
    opacity: 0.1;
    transform: rotate(15deg);
  }

  .visi-content:hover {
    transform: translateX(10px) translateY(-10px) rotate(1deg);
    box-shadow: 0 15px 40px rgba(253, 216, 53, 0.3), 0 0 0 2px rgba(253, 216, 53, 0.2);
  }

  .misi-content:hover {
    transform: translateX(-10px) translateY(-10px) rotate(-1deg);
    box-shadow: 0 15px 40px rgba(253, 216, 53, 0.3), 0 0 0 2px rgba(253, 216, 53, 0.2);
  }

  .visi-item::after,
  .misi-item::after {
    content: "";
    position: absolute;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, rgba(253, 216, 53, 0.3) 0%, transparent 70%);
    border-radius: 50%;
    z-index: 0;
    animation: pulse 2s ease-in-out infinite;
  }

  .visi-item::after {
    top: -30px;
    left: 50px;
  }

  .misi-item::after {
    width: 120px;
    height: 120px;
    bottom: -40px;
    right: 80px;
    animation-delay: 0.5s;
  }

  @keyframes pulse {

    0%,
    100% {
      transform: scale(1);
      opacity: 0.5;
    }

    50% {
      transform: scale(1.2);
      opacity: 0.8;
    }
  }

  .misi-content ul {
    margin: 0;
    padding-left: 0;
    list-style: none;
  }

  .misi-content ul li {
    position: relative;
    padding-left: 35px;
    margin-bottom: 20px;
    transition: transform 0.3s ease;
  }

  .misi-content ul li:hover {
    transform: translateX(10px);
  }

  .misi-content ul li:before {
    content: "";
    position: absolute;
    left: 0;
    top: 8px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(255, 107, 107, 0.3);
    transition: all 0.3s ease;
  }

  .misi-content ul li:hover:before {
    transform: scale(1.2);
  }

  .misi-content ul li:nth-child(1):before {
    background: linear-gradient(135deg, #fdd835, #ffb300);
    box-shadow: 0 2px 5px rgba(253, 216, 53, 0.3);
  }

  .misi-content ul li:nth-child(2):before {
    background: linear-gradient(135deg, #4ecdc4, #44a3a3);
    box-shadow: 0 2px 5px rgba(78, 205, 196, 0.3);
  }

  .misi-content ul li:nth-child(3):before {
    background: linear-gradient(135deg, #95e1d3, #6fcf97);
    box-shadow: 0 2px 5px rgba(149, 225, 211, 0.3);
  }

  .struktur {
    margin: 60px 0 40px;
    text-align: center;
    padding: 50px 30px;
    position: relative;
    background: linear-gradient(135deg, rgba(255, 249, 230, 0.3) 0%, rgba(255, 251, 240, 0.3) 100%);
    border-radius: 30px;
  }

  .struktur::before {
    content: '👥';
    position: absolute;
    font-size: 120px;
    top: -30px;
    left: -30px;
    opacity: 0.05;
  }

  .struktur::after {
    content: '🏆';
    position: absolute;
    font-size: 100px;
    bottom: -20px;
    right: -20px;
    opacity: 0.05;
  }

  .struktur h3 {
    font-family: 'Caveat Brush', cursive;
    font-size: 32px;
    margin-bottom: 40px;
    color: #fbbf24;
    animation: fadeInDown 0.8s ease;
  }

  .struktur-level {
    display: flex;
    justify-content: center;
    margin-bottom: 25px;
    gap: 50px;
  }

  .card {
    text-align: center;
    width: 170px;
    transition: all 0.4s ease;
    animation: fadeInUp 0.8s ease;
    animation-fill-mode: both;
    position: relative;
  }

  .card::before {
    content: '⭐';
    position: absolute;
    top: -15px;
    right: -10px;
    font-size: 24px;
    opacity: 0;
    transition: all 0.3s ease;
  }

  .card:hover::before {
    opacity: 1;
    transform: rotate(72deg);
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

  .card:hover {
    transform: translateY(-10px);
  }

  .card-image-wrapper {
    position: relative;
    display: inline-block;
  }

  .card-image-wrapper::before {
    content: '';
    position: absolute;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(253, 216, 53, 0.3), rgba(255, 179, 0, 0.3));
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    z-index: -1;
    transition: all 0.4s ease;
  }

  .card:hover .card-image-wrapper::before {
    transform: translateX(-50%) scale(1.15);
  }

  .card img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid #fdd835;
    background-color: #fff;
    transition: all 0.4s ease;
    box-shadow: 0 5px 15px rgba(253, 216, 53, 0.3);
  }

  .card img:hover {
    transform: scale(1.1) rotate(5deg);
    border-color: #ffb300;
    box-shadow: 0 8px 25px rgba(253, 216, 53, 0.5);
  }

  .jabatan {
    font-size: 14px;
    font-weight: 700;
    background: linear-gradient(135deg, #fdd835, #ffb300);
    color: #ffffff;
    border-radius: 20px;
    margin-top: 12px;
    padding: 8px 12px;
    box-shadow: 0 3px 8px rgba(253, 216, 53, 0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .jabatan::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.4s ease, height 0.4s ease;
  }

  .card:hover .jabatan::before {
    width: 200px;
    height: 200px;
  }

  .card:hover .jabatan {
    transform: scale(1.05);
    box-shadow: 0 5px 12px rgba(253, 216, 53, 0.5);
  }

  .nama {
    font-size: 13px;
    margin-top: 8px;
    font-weight: 600;
    color: #333;
    transition: color 0.3s ease;
  }

  .card:hover .nama {
    color: #ffb300;
  }

  .line {
    width: 3px;
    height: 30px;
    background: linear-gradient(to bottom, #fdd835, #ffb300);
    margin: 0 auto 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(253, 216, 53, 0.3);
    animation: growDown 0.6s ease;
    position: relative;
  }

  .line::before,
  .line::after {
    content: '';
    position: absolute;
    width: 10px;
    height: 10px;
    background: #fdd835;
    border-radius: 50%;
    left: 50%;
    transform: translateX(-50%);
  }

  .line::before {
    top: -5px;
  }

  .line::after {
    bottom: -5px;
  }

  @keyframes growDown {
    from {
      height: 0;
      opacity: 0;
    }

    to {
      height: 30px;
      opacity: 1;
    }
  }

  /* RESPONSIVE */
  @media (max-width: 768px) {
    main {
      padding: 20px;
      margin: 20px auto;
    }

    h1 {
      font-size: 2em;
      margin-bottom: 15px;
    }

    .stats-container {
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
      margin: 30px 0;
    }

    .stat-card {
      padding: 25px 15px;
    }

    .stat-icon {
      font-size: 40px;
      margin-bottom: 10px;
    }

    .stat-number {
      font-size: 28px;
    }

    .stat-label {
      font-size: 12px;
    }

    .about {
      flex-direction: column;
      padding: 30px 25px;
      gap: 25px;
    }

    .about-image-wrapper {
      width: 100%;
    }

    .about img {
      width: 100%;
      max-width: 300px;
      margin: 0 auto;
    }

    .about-text {
      font-size: 15px;
      line-height: 1.8;
    }

    .about-text p {
      padding-left: 15px;
    }

    .section-divider {
      margin: 50px 0 40px;
    }

    .section-divider span {
      font-size: 24px;
    }

    .section-divider::before,
    .section-divider::after {
      width: 25%;
    }

    .visi-item,
    .misi-item {
      flex-direction: column;
      gap: 25px;
      margin-bottom: 50px;
    }

    .visi-badge,
    .misi-badge {
      font-size: 48px;
      min-width: auto;
    }

    .visi-content,
    .misi-content {
      max-width: 100%;
      padding: 30px 25px;
      font-size: 15px;
    }

    .visi-content:hover,
    .misi-content:hover {
      transform: translateY(-8px) rotate(0deg);
    }

    .misi-content ul li {
      padding-left: 35px;
      margin-bottom: 20px;
    }

    .struktur {
      padding: 35px 20px;
      margin-top: 50px;
    }

    .struktur h3 {
      font-size: 28px;
      margin-bottom: 35px;
    }

    .struktur-level {
      gap: 30px;
      flex-wrap: wrap;
    }

    .card {
      width: 150px;
    }

    .card img {
      width: 100px;
      height: 100px;
    }

    .card-image-wrapper::before {
      width: 100px;
      height: 100px;
    }

    .jabatan {
      font-size: 12px;
      padding: 8px 12px;
    }

    .nama {
      font-size: 12px;
    }

    .line {
      height: 25px;
    }

    .floating-emoji {
      display: none;
    }
  }

  @media (max-width: 480px) {
    h1 {
      font-size: 1.8em;
    }

    .stats-container {
      grid-template-columns: 1fr;
    }

    .stat-card {
      padding: 20px 15px;
    }

    .about {
      padding: 25px 20px;
    }

    .about img {
      max-width: 250px;
    }

    .about-text {
      font-size: 14px;
    }

    .section-divider span {
      font-size: 20px;
    }

    .visi-badge,
    .misi-badge {
      font-size: 40px;
    }

    .visi-content,
    .misi-content {
      padding: 25px 20px;
      font-size: 14px;
    }

    .struktur {
      padding: 30px 15px;
    }

    .struktur h3 {
      font-size: 24px;
    }

    .struktur-level {
      gap: 25px;
    }

    .card {
      width: 140px;
    }

    .card img {
      width: 90px;
      height: 90px;
    }

    .card-image-wrapper::before {
      width: 90px;
      height: 90px;
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

<main class="container">
  <h1 style="color: #fbbf24; font-size: 2.5em;">TENTANG</h1>

  <div class="about">
    <div class="about-image-wrapper">
      <img src="pict/home.png" alt="Foto Tentang">
    </div>
    <div class="about-text">
      <p><b>Perkumpulan Inovasi Kata Karsa (PIKK)</b> adalah komunitas sosial yang berfokus pada pengembangan literasi, pendidikan, dan pelestarian budaya.</p>
      <p>Kami percaya bahwa kata bisa menumbuhkan karsa – semangat untuk berinovasi, berkolaborasi, dan berkarya bagi masyarakat. Melalui berbagai program dan kegiatan, PIKK menjadi ruang bagi generasi muda untuk belajar, berdialog, dan menciptakan perubahan positif.</p>
    </div>
  </div>

  <div class="section-divider">
    <span>✨ VISI & MISI ✨</span>
  </div>

  <div class="visi-misi">
    <div class="visi-item">
      <div class="visi-badge">VISI</div>
      <div class="visi-content">
        <p>Menciptakan transformasi positif melalui inovasi dalam sosial, pendidikan, dan literasi untuk membangun masyarakat yang cerdas, kreatif, berbudaya, dan peduli.</p>
      </div>
    </div>

    <div class="misi-item">
      <div class="misi-content">
        <ul>
          <li>Mengembangkan program inovatif dalam bidang pendidikan yang memungkinkan akses pendidikan yang berkualitas bagi semua lapisan masyarakat, sehingga menciptakan generasi yang cerdas dan kreatif.</li>
          <li>Mendorong literasi dan kesadaran sosial melalui kegiatan edukasi yang membantu meningkatkan pemahaman masyarakat, sehingga tercipta masyarakat yang peduli dan berbudaya.</li>
          <li>Berkolaborasi dengan berbagai pihak untuk menciptakan lingkungan inklusif yang mendukung pertumbuhan dan perkembangan masyarakat, sehingga terwujud transformasi positif yang berkelanjutan.</li>
        </ul>
      </div>
      <div class="misi-badge">MISI</div>
    </div>
  </div>

  <div class="struktur">
    <h3>STRUKTUR ORGANISASI</h3>

    <div class="struktur-level">
      <div class="card">
        <div class="card-image-wrapper">
          <img src="pict/pengawas 1.png" alt="Pengawas 1">
        </div>
        <div class="jabatan">PENGAWAS</div>
        <div class="nama">Hery Arianto, S.Pd.I</div>
      </div>
      <div class="card">
        <div class="card-image-wrapper">
          <img src="pict/pengawas 2.png" alt="Pengawas 2">
        </div>
        <div class="jabatan">PENGAWAS</div>
        <div class="nama">Dr. Ita Nurcholifah, SE.I, MM</div>
      </div>
    </div>

    <div class="line"></div>

    <div class="struktur-level">
      <div class="card">
        <div class="card-image-wrapper">
          <img src="pict/ketua.png" alt="Ketua">
        </div>
        <div class="jabatan">KETUA</div>
        <div class="nama">Anisa Maharani Arianto</div>
      </div>
    </div>

    <div class="line"></div>

    <div class="struktur-level">
      <div class="card">
        <div class="card-image-wrapper">
          <img src="pict/bendahara.png" alt="Bendahara">
        </div>
        <div class="jabatan">BENDAHARA</div>
        <div class="nama">Safira Rizky Rahmadini</div>
      </div>
      <div class="card">
        <div class="card-image-wrapper">
          <img src="pict/sekretaris.png" alt="Sekretaris">
        </div>
        <div class="jabatan">SEKRETARIS</div>
        <div class="nama">Nia Sukmawati Rochania, S.E</div>
      </div>
    </div>
  </div>
</main>

<?php include 'footer.php'; ?>