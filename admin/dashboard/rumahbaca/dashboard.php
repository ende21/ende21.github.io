<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../../login.php");
    exit;
}

// Cek role pengurus
if ($_SESSION['role'] != 'pengurus') {
    header("Location: ../index.php");
    exit;
}

include '../../config/conn_db.php';
$nama = $_SESSION['nama'];

$success = '';
$error = '';

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jumlah_buku = intval($_POST['jumlah_buku']);
    $alamat = mysqli_real_escape_string($conn, trim($_POST['alamat']));
    $link_maps = mysqli_real_escape_string($conn, trim($_POST['link_maps']));
    $nomor_wa = mysqli_real_escape_string($conn, trim($_POST['nomor_wa']));

    $query = "UPDATE teras_baca_settings SET 
              jumlah_buku = '$jumlah_buku',
              alamat = '$alamat',
              link_maps = '$link_maps',
              nomor_wa = '$nomor_wa'
              WHERE id = 1";


    if (mysqli_query($conn, $query)) {
        $success = 'Data berhasil diperbarui!';
    } else {
        $error = 'Gagal memperbarui data: ' . mysqli_error($conn);
    }
}

// Ambil data saat ini
$result = mysqli_query($conn, "SELECT * FROM teras_baca_settings WHERE id = 1");
$settings = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Teras Baca | PIKK</title>
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
            position: fixed;
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
            margin-left: 230px;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            margin-top: 25px;
            margin-right: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #FFD43B;
            box-shadow: 0 0 0 0.2rem rgba(255, 212, 59, 0.25);
        }

        .btn-yellow {
            background-color: #FFD43B;
            color: #000;
            font-weight: 600;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            transition: 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-yellow:hover {
            background-color: #ffce33;
            transform: translateY(-2px);
        }

        .info-box {
            background: linear-gradient(135deg, #FFF9E6 0%, #FFF5CC 100%);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #FFD43B;
        }

        .info-box i {
            font-size: 2rem;
            color: #FFD43B;
        }

        .preview-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            border: 2px dashed #dee2e6;
        }

        .preview-box h6 {
            color: #666;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .preview-item {
            background: white;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .preview-item i {
            color: #FFD43B;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div><i class="bi bi-circle-fill me-2" style="font-size:0.8rem;"></i>INOVASIKATAKARSA.ID</div>
        <a href="../../logout.php" class="text-dark text-decoration-none">Logout</a>
    </div>

    <div class="d-flex">
        <div class="sidebar">
            <a href="../index.php" class="menu-item">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
            <a href="../berita/list.php" class="menu-item">
                <i class="bi bi-file-earmark-text"></i> Kelola Berita
            </a>
            <a href="../../dashboard/rumahbaca/dashboard.php" class="menu-item">
                <i class="bi bi-collection"></i> Kelola Teras Baca
            </a>
            <a href="../kegiatan/list.php" class="menu-item">
                <i class="bi bi-calendar-event"></i> Kelola Kegiatan
            </a>
            <a href="../profile.php" class="menu-item">
                <i class="bi bi-gear"></i> Pengaturan Profil
            </a>
        </div>

        <!-- KONTEN UTAMA -->
        <div class="content flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold mb-0">
                    <i class="bi bi-book me-2"></i> KELOLA TERAS BACA
                </h4>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?php echo htmlspecialchars($success); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="info-box">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-info-circle"></i>
                    <div>
                        <h6 class="mb-1 fw-semibold">Informasi</h6>
                        <p class="mb-0 text-muted small">
                            Kelola informasi Teras Baca yang akan ditampilkan di website publik.
                            Terakhir diupdate: <strong><?= date('d/m/Y H:i', strtotime($settings['updated_at'])) ?></strong>
                        </p>
                    </div>
                </div>
            </div>

            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-book-half me-2"></i> Jumlah Buku
                            </label>
                            <input type="number" class="form-control" name="jumlah_buku"
                                value="<?= htmlspecialchars($settings['jumlah_buku']) ?>"
                                required min="0">
                            <small class="text-muted">Masukkan jumlah total buku yang tersedia</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-whatsapp me-2"></i> Nomor WhatsApp
                            </label>
                            <input type="text" class="form-control" name="nomor_wa"
                                value="<?= htmlspecialchars($settings['nomor_wa']) ?>"
                                required placeholder="6281234567890">
                            <small class="text-muted">Format: 62 + nomor (tanpa 0 di awal)</small>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-geo-alt me-2"></i> Alamat Teras Baca
                    </label>
                    <textarea class="form-control" name="alamat" rows="3" required><?= htmlspecialchars($settings['alamat']) ?></textarea>
                    <small class="text-muted">Alamat lengkap lokasi Teras Baca</small>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-map me-2"></i> Link Google Maps
                    </label>
                    <input type="url" class="form-control" name="link_maps"
                        value="<?= htmlspecialchars($settings['link_maps']) ?>"
                        required placeholder="https://www.google.com/maps/place/...">
                    <small class="text-muted">URL lengkap Google Maps lokasi Teras Baca</small>
                </div>


                <!-- Preview Box -->
                <div class="preview-box">
                    <h6><i class="bi bi-eye me-2"></i> Preview Data</h6>
                    <div class="preview-item">
                        <i class="bi bi-book-half"></i>
                        <span><strong>Jumlah Buku:</strong> <?= number_format($settings['jumlah_buku']) ?> Buku</span>
                    </div>
                    <div class="preview-item">
                        <i class="bi bi-geo-alt"></i>
                        <span><strong>Alamat:</strong> <?= htmlspecialchars($settings['alamat']) ?></span>
                    </div>
                    <div class="preview-item">
                        <i class="bi bi-whatsapp"></i>
                        <span><strong>WhatsApp:</strong> <?= htmlspecialchars($settings['nomor_wa']) ?></span>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-yellow flex-grow-1">
                        <i class="bi bi-save me-2"></i> Simpan Perubahan
                    </button>
                    <a href="../index.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>