<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PIKK</title>
  <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Caveat Brush', cursive;
      background: linear-gradient(to bottom, #fff9e6 0%, #f4f4f4 100%);
      min-height: 100vh;
    }

    /* NAVBAR */
    .navbar {
      background: #FFDE59;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 999;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      font-family: 'Caveat Brush', cursive;
    }

    /* LOGO */
    .logo {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: #ffffffff;
    }

    .logo img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: white;
      padding: 5px;
      border: 2px solid #ffc107;
    }

    .logo span {
      font-size: 1.8em;
      font-weight: bold;
    }

    /* MENU DESKTOP */
    .nav-menu {
      display: flex;
      list-style: none;
      gap: 10px;
      margin: 0;
      padding: 0;
    }

    .nav-menu a {
      text-decoration: none;
      color: #ffffffff;
      font-size: 1.4em;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 25px;
      transition: all 0.3s;
    }

    .nav-menu a:hover,
    .nav-menu a.active {
      background: #ffc107;
      color: #ffffffff;
    }

    /* BURGER */
    .burger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      padding: 8px;
      background: #ffc107;
      border-radius: 8px;
    }

    .burger span {
      width: 25px;
      height: 3px;
      background: #1a1a1a;
      border-radius: 2px;
      transition: 0.3s;
    }

    .burger.active span:nth-child(1) {
      transform: rotate(45deg) translate(7px, 7px);
    }

    .burger.active span:nth-child(2) {
      opacity: 0;
    }

    .burger.active span:nth-child(3) {
      transform: rotate(-45deg) translate(7px, -7px);
    }

    /* CONTENT SPACING */
    .content {
      margin-top: 100px;
      padding: 20px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .navbar {
        padding: 15px 20px;
      }

      .logo span {
        font-size: 1.2em;
      }

      .logo img {
        width: 40px;
        height: 40px;
      }

      .burger {
        display: flex;
      }

      .nav-menu {
        position: fixed;
        left: -100%;
        top: 70px;
        flex-direction: column;
        background: #FFDE59;
        width: 100%;
        text-align: center;
        transition: 0.3s;
        gap: 0;
        padding: 20px 0;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      }

      .nav-menu.active {
        left: 0;
      }

      .nav-menu li {
        padding: 10px 0;
      }

      .nav-menu a {
        display: block;
        width: 80%;
        margin: 0 auto;
      }

      .content {
        margin-top: 80px;
      }
    }

    @media (max-width: 480px) {
      .logo span {
        font-size: 1em;
      }

      .logo img {
        width: 35px;
        height: 35px;
      }

      .nav-menu {
        top: 65px;
      }

      .content {
        margin-top: 75px;
      }
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar">
    <a href="admin/login.php" class="logo">
      <img src="logo/logo pikk.png" alt="PIKK">
      <span>INOVASIKATAKARSA.ID</span>
    </a>

    <div class="burger" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <ul class="nav-menu" id="navMenu">
      <li><a href="Beranda.php">BERANDA</a></li>
      <li><a href="Tentang.php">TENTANG</a></li>
      <li><a href="Berita.php">BERITA</a></li>
      <li><a href="Kegiatan.php">KEGIATAN</a></li>
    </ul>
  </nav>

  <script>
    function toggleMenu() {
      const menu = document.getElementById('navMenu');
      const burger = document.querySelector('.burger');
      menu.classList.toggle('active');
      burger.classList.toggle('active');
    }

    // Auto detect active page
    window.addEventListener('DOMContentLoaded', function() {
      const currentPage = window.location.pathname.split('/').pop();
      const links = document.querySelectorAll('.nav-menu a');
      
      links.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
          link.classList.add('active');
        }
      });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
      const menu = document.getElementById('navMenu');
      const burger = document.querySelector('.burger');
      const navbar = document.querySelector('.navbar');
      
      if (!navbar.contains(e.target) && menu.classList.contains('active')) {
        menu.classList.remove('active');
        burger.classList.remove('active');
      }
    });

    // Close menu when link clicked
    document.querySelectorAll('.nav-menu a').forEach(link => {
      link.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
          document.getElementById('navMenu').classList.remove('active');
          document.querySelector('.burger').classList.remove('active');
        }
      });
    });
  </script>

</body>
</html>
