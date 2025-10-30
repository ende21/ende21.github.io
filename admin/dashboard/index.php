<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

include '../config/conn_db.php';
$role = $_SESSION['role'];
$nama = $_SESSION['nama'];

$berita = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM berita"))['jml'];
$kegiatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS jml FROM programs"))['jml'];
$total = $berita + $kegiatan;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | PIKK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F5F5F5;
            margin: 0;
            overflow-x: hidden;
        }

        .header {
            background-color: #FFD43B;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .sidebar {
            width: 230px;
            background-color: #fff;
            height: calc(100vh - 70px);
            padding: 20px 0;
            border-right: 1px solid #eee;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 25px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .menu-item:hover,
        .menu-item.active {
            background-color: #FFF5CC;
            color: #000;
        }

        .menu-item i {
            font-size: 1.1rem;
        }

        .content {
            padding: 40px;
            flex-grow: 1;
            background-color: #fff;
            border-radius: 10px;
            margin: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-stat {
            border: none;
            border-radius: 10px;
            background-color: #FFF;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-yellow {
            background-color: #FFD43B;
            color: #000;
            font-weight: 600;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            transition: 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-yellow:hover {
            background-color: #ffce33;
        }

        .btn-outline-secondary {
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div><i class="bi bi-circle-fill me-2" style="font-size:0.8rem;"></i>INOVASIKATAKARSA.ID</div>
        <a href="../logout.php" class="text-dark text-decoration-none">Logout</a>
    </div>

    <div class="d-flex">
        <div class="sidebar d-flex flex-column">
            <a href="index.php" class="menu-item active">
                <i class="bi bi-house-door"></i> Dashboard
            </a>

            <?php if ($role == 'pengurus'): ?>
                <a href="berita/list.php" class="menu-item">
                    <i class="bi bi-file-earmark-text"></i> Kelola Berita
                </a>
                <a href="../dashboard/rumahbaca/dashboard.php" class="menu-item">
                    <i class="bi bi-collection"></i> Kelola Teras Baca
                </a>
            <?php endif; ?>

            <a href="kegiatan/list.php" class="menu-item">
                <i class="bi bi-calendar-event"></i> Kelola Kegiatan
            </a>

            <a href="profile.php" class="menu-item">
                <i class="bi bi-gear"></i> Pengaturan Profil
            </a>
        </div>

        <!-- KONTEN UTAMA -->
        <div class="content flex-grow-1">
            <h4 class="fw-semibold mb-4">Selamat Datang, <?= $nama ?> 👋</h4>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card card-stat text-center p-3">
                        <h6>BERITA</h6>
                        <h2><?= $berita ?></h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stat text-center p-3">
                        <h6>KEGIATAN</h6>
                        <h2><?= $kegiatan ?></h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stat text-center p-3">
                        <h6>TOTAL</h6>
                        <h2><?= $total ?></h2>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column align-items-center gap-3">
                <?php if ($role == 'pengurus'): ?>
                    <a href="berita/tambah.php" class="btn btn-yellow w-50">TAMBAH BERITA BARU</a>
                <?php endif; ?>
                <a href="kegiatan/tambah.php" class="btn btn-outline-secondary w-50">TAMBAH KEGIATAN</a>
            </div>
        </div>
    </div>

</body>

</html>