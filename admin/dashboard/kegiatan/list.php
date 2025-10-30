<?php
session_start();
include '../../config/conn_db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

$role = $_SESSION['role'];
$nama = $_SESSION['nama'];

// Query program dari database
$result = mysqli_query($conn, "SELECT * FROM programs ORDER BY tanggal DESC, id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kegiatan | PIKK</title>
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

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #FFF5CC;
            border-bottom: 2px solid #FFD43B;
            font-weight: 600;
            white-space: nowrap;
        }

        .table-hover tbody tr:hover {
            background-color: #FFFEF8;
        }

        .table td {
            vertical-align: middle;
        }

        /* Lebar kolom */
        .col-no {
            width: 50px;
        }

        .col-gambar {
            width: 100px;
        }

        .col-judul {
            min-width: 250px;
            max-width: 400px;
        }

        .col-kategori {
            width: 120px;
        }

        .col-tanggal {
            width: 120px;
        }

        .col-status {
            width: 100px;
        }

        .col-aksi {
            width: 180px;
            text-align: center;
        }

        /* Styling untuk judul */
        .judul-program {
            line-height: 1.4;
            word-wrap: break-word;
        }

        .img-thumbnail-custom {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #f0f0f0;
        }

        .badge-pikk {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 5px 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge-kolaborasi {
            background-color: #fce7f3;
            color: #9f1239;
            padding: 5px 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge-aktif {
            background-color: #d1fae5;
            color: #065f46;
            padding: 5px 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .badge-nonaktif {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 5px 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .btn-action {
            padding: 6px 12px;
            font-size: 14px;
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
            <a href="../berita/list.php" class="menu-item">
                <i class="bi bi-file-earmark-text"></i> Kelola Berita
            </a>
            <a href="../rumahbaca/dashboard.php" class="menu-item">
                <i class="bi bi-collection"></i> Kelola Teras Baca
            </a>
        <?php endif; ?>

        <a href="list.php" class="menu-item active">
            <i class="bi bi-calendar-event"></i> Kelola Kegiatan
        </a>

        <a href="../profile.php" class="menu-item">
            <i class="bi bi-gear"></i> Pengaturan Profil
        </a>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="content-wrapper">
        <div class="content">
            <!-- Notifikasi -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold mb-0"><i class="bi bi-calendar-check me-2"></i>Daftar Program</h4>
                <a href="tambah.php" class="btn btn-yellow">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Program
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="col-no">#</th>
                            <th class="col-gambar">Gambar</th>
                            <th class="col-judul">Judul Program</th>
                            <th class="col-kategori">Kategori</th>
                            <th class="col-tanggal">Tanggal</th>
                            <th class="col-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php $no = 1;
                            while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <img src="../../../pict/<?= htmlspecialchars($row['gambar']); ?>"
                                            alt="<?= htmlspecialchars($row['judul']); ?>"
                                            class="img-thumbnail-custom">
                                    </td>
                                    <td>
                                        <div class="judul-program">
                                            <?= htmlspecialchars($row['judul']); ?>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($row['lokasi']); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge-<?= $row['kategori']; ?>">
                                            <?= strtoupper($row['kategori']); ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="edit.php?id=<?= $row['id']; ?>"
                                                class="btn btn-sm btn-outline-warning btn-action"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="hapus.php?id=<?= $row['id']; ?>"
                                                class="btn btn-sm btn-outline-danger btn-action"
                                                onclick="return confirm('Yakin ingin menghapus program ini?')"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="mt-2 text-muted">Belum ada program</p>
                                    <a href="tambah.php" class="btn btn-yellow btn-sm">
                                        <i class="bi bi-plus-circle"></i> Tambah Program Pertama
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Total Data -->
            <?php if (mysqli_num_rows($result) > 0): ?>
                <div class="mt-3 text-muted">
                    <small>Total: <strong><?= mysqli_num_rows($result); ?></strong> program</small>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>