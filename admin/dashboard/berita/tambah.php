<?php
session_start();
include '../../config/conn_db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

$role = $_SESSION['role'];
$nama = $_SESSION['nama'];

if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $link_berita = $_POST['link_berita'];
    $tanggal = date('Y-m-d H:i:s');

    $sql = "INSERT INTO berita (judul, link_berita, tanggal) VALUES ('$judul', '$link_berita', '$tanggal')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = 'Berita berhasil ditambahkan!';
        $_SESSION['message_type'] = 'success';
        header('Location: list.php');
        exit;
    } else {
        $_SESSION['message'] = 'Gagal menambahkan berita: ' . mysqli_error($conn);
        $_SESSION['message_type'] = 'danger';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita | PIKK</title>
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
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .sidebar {
            width: 230px;
            background-color: #fff;
            height: 100vh;
            padding: 20px 0;
            border-right: 1px solid #eee;
            position: fixed;
            top: 70px;
            left: 0;
            overflow-y: auto;
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

        .content-wrapper {
            margin-left: 230px;
            margin-top: 70px;
            padding: 30px 40px;
            min-height: calc(100vh - 70px);
        }

        .content {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .btn-yellow {
            background-color: #FFD43B;
            color: #000;
            font-weight: 600;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .btn-yellow:hover {
            background-color: #ffce33;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        label {
            font-weight: 500;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div><i class="bi bi-circle-fill me-2" style="font-size:0.8rem;"></i>INOVASIKATAKARSA.ID</div>
        <a href="../../logout.php" class="text-dark text-decoration-none">Logout</a>
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar d-flex flex-column">
        <a href="../index.php" class="menu-item">
            <i class="bi bi-house-door"></i> Dashboard
        </a>

        <?php if ($role == 'pengurus'): ?>
            <a href="list.php" class="menu-item active">
                <i class="bi bi-file-earmark-text"></i> Kelola Berita
            </a>
            <a href="../rumahbaca/dashboard.php" class="menu-item">
                <i class="bi bi-collection"></i> Kelola Teras Baca
            </a>
        <?php endif; ?>

        <a href="../kegiatan/list.php" class="menu-item">
            <i class="bi bi-calendar-event"></i> Kelola Kegiatan
        </a>

        <a href="../profile.php" class="menu-item">
            <i class="bi bi-gear"></i> Pengaturan Profil
        </a>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="content-wrapper">
        <div class="content">
            <h4 class="fw-semibold mb-4"><i class="bi bi-plus-circle me-2"></i>Tambah Berita</h4>

            <form method="post">
                <div class="mb-3">
                    <label>Judul Berita</label>
                    <input type="text" name="judul" required>
                </div>

                <div class="mb-3">
                    <label>Link Berita (URL)</label>
                    <input type="text" name="link_berita" required>
                </div>

                <div class="mt-4">
                    <button type="submit" name="simpan" class="btn btn-yellow">Simpan</button>
                    <a href="list.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>