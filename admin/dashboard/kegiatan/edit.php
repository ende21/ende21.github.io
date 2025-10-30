<?php
session_start();
include '../../config/conn_db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

$role = $_SESSION['role'];
$nama = $_SESSION['nama'];

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data program
$query = mysqli_query($conn, "SELECT * FROM programs WHERE id = $id");
$program = mysqli_fetch_assoc($query);

if (!$program) {
    $_SESSION['message'] = 'Program tidak ditemukan!';
    $_SESSION['message_type'] = 'danger';
    header('Location: list.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($conn, trim($_POST['judul']));
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $lokasi = mysqli_real_escape_string($conn, trim($_POST['lokasi']));
    $deskripsi = mysqli_real_escape_string($conn, trim($_POST['deskripsi']));

    // Validasi input
    $errors = [];

    if (empty($judul)) {
        $errors[] = 'Judul harus diisi';
    }

    if (empty($kategori)) {
        $errors[] = 'Kategori harus dipilih';
    }

    if (empty($tanggal)) {
        $errors[] = 'Tanggal harus diisi';
    }

    if (empty($lokasi)) {
        $errors[] = 'Lokasi harus diisi';
    }

    if (empty($deskripsi)) {
        $errors[] = 'Deskripsi harus diisi';
    }

    // Generate slug jika judul berubah
    $slug = $program['slug'];
    if ($judul != $program['judul']) {
        $new_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul)));
        $new_slug = trim($new_slug, '-');

        // Cek apakah slug baru sudah ada (kecuali untuk program ini sendiri)
        $check_slug = mysqli_query($conn, "SELECT id FROM programs WHERE slug = '$new_slug' AND id != $id");
        if (mysqli_num_rows($check_slug) > 0) {
            $new_slug = $new_slug . '-' . time();
        }
        $slug = $new_slug;
    }

    // Upload gambar baru (opsional)
    $gambar_name = $program['gambar'];
    $gambar_updated = false;

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['gambar']['name'];
        $filesize = $_FILES['gambar']['size'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        // Validasi ekstensi
        if (!in_array($ext, $allowed)) {
            $errors[] = 'Format gambar harus JPG, JPEG, PNG, atau GIF';
        }

        // Validasi ukuran file (max 5MB)
        if ($filesize > 5242880) {
            $errors[] = 'Ukuran gambar maksimal 5MB';
        }

        if (empty($errors)) {
            // Backup gambar lama
            $old_gambar = $program['gambar'];

            // Cari nomor terakhir dari database
            $query_last = "SELECT gambar FROM programs ORDER BY id DESC LIMIT 1";
            $result_last = mysqli_query($conn, $query_last);

            $next_number = 1; // Default nomor pertama

            if (mysqli_num_rows($result_last) > 0) {
                $last_row = mysqli_fetch_assoc($result_last);
                $last_gambar = $last_row['gambar'];

                // Ekstrak nomor dari nama file terakhir (misal: gambar5.jpg -> 5)
                if (preg_match('/gambar(\d+)\./', $last_gambar, $matches)) {
                    $next_number = intval($matches[1]) + 1;
                }
            }

            // Generate nama file: gambar1.jpg, gambar2.jpg, dst
            $gambar_name = 'gambar' . $next_number . '.' . $ext;
            $upload_path = '../../../pict/' . $gambar_name;

            // Cek apakah file sudah ada (untuk safety)
            while (file_exists($upload_path)) {
                $next_number++;
                $gambar_name = 'gambar' . $next_number . '.' . $ext;
                $upload_path = '../../../pict/' . $gambar_name;
            }

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
                $gambar_updated = true;

                // Hapus gambar lama jika berhasil upload gambar baru
                if (file_exists('../../../pict/' . $old_gambar)) {
                    unlink('../../../pict/' . $old_gambar);
                }
            } else {
                $errors[] = 'Gagal upload gambar baru';
                $gambar_name = $old_gambar; // Kembalikan ke gambar lama
            }
        }
    }

    // Update database jika tidak ada error
    if (empty($errors)) {
        $query = "UPDATE programs SET 
                  kategori = '$kategori', 
                  judul = '$judul', 
                  tanggal = '$tanggal', 
                  lokasi = '$lokasi', 
                  deskripsi = '$deskripsi', 
                  gambar = '$gambar_name', 
                  slug = '$slug',
                  updated_at = NOW()
                  WHERE id = $id";

        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = 'Program berhasil diupdate!';
            $_SESSION['message_type'] = 'success';
            header('Location: list.php');
            exit;
        } else {
            $errors[] = 'Error database: ' . mysqli_error($conn);

            // Hapus gambar baru jika gagal update database
            if ($gambar_updated && file_exists('../../../pict/' . $gambar_name)) {
                unlink('../../../pict/' . $gambar_name);
            }
        }
    }

    // Jika ada error, reload data program terbaru untuk ditampilkan
    if (!empty($errors)) {
        $program['judul'] = $judul;
        $program['kategori'] = $kategori;
        $program['tanggal'] = $tanggal;
        $program['lokasi'] = $lokasi;
        $program['deskripsi'] = $deskripsi;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Program | PIKK</title>
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
            max-width: 900px;
        }

        .btn-yellow {
            background-color: #FFD43B;
            color: #000;
            font-weight: 600;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .btn-yellow:hover {
            background-color: #ffce33;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #FFD43B;
            box-shadow: 0 0 0 0.2rem rgba(255, 212, 59, 0.25);
        }

        textarea.form-control {
            min-height: 120px;
        }

        .required {
            color: #dc3545;
        }

        .hint-text {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 5px;
        }

        .current-image-box {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            background: #f9fafb;
        }

        .current-image-box img {
            max-width: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .image-preview {
            margin-top: 15px;
            display: none;
        }

        .image-preview img {
            max-width: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .alert ul {
            margin: 10px 0 0 0;
            padding-left: 20px;
        }

        .alert ul li {
            margin-bottom: 5px;
        }

        .info-box {
            background: #e0f2fe;
            border-left: 4px solid #0284c7;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-box i {
            color: #0284c7;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div><i class="bi bi-circle-fill me-2" style="font-size:0.8rem;"></i> ORGANISASI</div>
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
                <i class="bi bi-collection"></i> Galeri Rumah Baca
            </a>
        <?php endif; ?>

        <a href="list.php" class="menu-item active">
            <i class="bi bi-calendar-event"></i> Kelola Program
        </a>

        <a href="../profil.php" class="menu-item">
            <i class="bi bi-gear"></i> Pengaturan Profil
        </a>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="content-wrapper">
        <div class="content">
            <!-- Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-exclamation-triangle me-2"></i>Terjadi Kesalahan:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold mb-0">
                    <i class="bi bi-pencil-square me-2"></i>Edit Program
                </h4>
                <a href="list.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="info-box">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Info:</strong> Anda sedang mengedit program "<strong><?php echo htmlspecialchars($program['judul']); ?></strong>".
                Perubahan akan langsung terlihat di website setelah disimpan.
            </div>

            <form method="POST" enctype="multipart/form-data" id="formProgram">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">
                            Kategori Program <span class="required">*</span>
                        </label>
                        <select name="kategori" id="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="pikk" <?php echo $program['kategori'] == 'pikk' ? 'selected' : ''; ?>>PIKK</option>
                            <option value="kolaborasi" <?php echo $program['kategori'] == 'kolaborasi' ? 'selected' : ''; ?>>Kolaborasi</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label">
                            Tanggal Pelaksanaan <span class="required">*</span>
                        </label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control"
                            value="<?php echo $program['tanggal']; ?>" required>
                        <div class="hint-text">Pilih tanggal pelaksanaan program</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="judul" class="form-label">
                        Judul Program <span class="required">*</span>
                    </label>
                    <input type="text" name="judul" id="judul" class="form-control"
                        value="<?php echo htmlspecialchars($program['judul']); ?>" required>
                    <div class="hint-text">Masukkan judul program yang menarik dan deskriptif</div>
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">
                        Lokasi <span class="required">*</span>
                    </label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control"
                        value="<?php echo htmlspecialchars($program['lokasi']); ?>" required>
                    <div class="hint-text">Lokasi tempat program dilaksanakan</div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">
                        Deskripsi Program <span class="required">*</span>
                    </label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" required><?php echo htmlspecialchars($program['deskripsi']); ?></textarea>
                    <div class="hint-text">Jelaskan tujuan, manfaat, dan kegiatan yang akan dilakukan dalam program ini</div>
                </div>

                <div class="mb-4">
                    <label for="gambar" class="form-label">
                        Gambar Program
                    </label>

                    <!-- Gambar Saat Ini -->
                    <div class="current-image-box">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-image me-2" style="font-size: 1.2rem; color: #0284c7;"></i>
                            <strong>Gambar Saat Ini:</strong>
                        </div>
                        <img src="../../../pict/<?php echo htmlspecialchars($program['gambar']); ?>"
                            alt="<?php echo htmlspecialchars($program['judul']); ?>"
                            id="currentImage">
                        <div class="mt-2 text-muted">
                            <small><i class="bi bi-file-earmark-image me-1"></i><?php echo $program['gambar']; ?></small>
                        </div>
                    </div>

                    <!-- Upload Gambar Baru -->
                    <input type="file" name="gambar" id="gambar" class="form-control"
                        accept="image/jpeg,image/jpg,image/png,image/gif">
                    <div class="hint-text">
                        <i class="bi bi-info-circle me-1"></i>
                        <strong>Opsional:</strong> Upload gambar baru untuk mengganti gambar saat ini.
                        Format: JPG, JPEG, PNG, GIF | Maksimal 5MB | Resolusi minimal 800x600px
                    </div>

                    <!-- Preview Gambar Baru -->
                    <div class="image-preview" id="imagePreview">
                        <p class="mt-3 mb-2"><strong><i class="bi bi-eye me-1"></i>Preview Gambar Baru:</strong></p>
                        <img id="previewImg" src="" alt="Preview">
                    </div>
                </div>

                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Perhatian:</strong> Jika Anda mengupload gambar baru, gambar lama akan otomatis terhapus dari server dan nama file akan menggunakan format "gambarX" sesuai urutan.
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-yellow">
                        <i class="bi bi-save me-1"></i> Update Program
                    </button>
                    <a href="list.php" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview gambar baru sebelum upload
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                document.getElementById('imagePreview').style.display = 'none';
            }
        });

        // Validasi form sebelum submit
        document.getElementById('formProgram').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('gambar');
            const file = fileInput.files[0];

            // Hanya validasi jika ada file yang diupload
            if (file) {
                // Cek ukuran file (5MB = 5242880 bytes)
                if (file.size > 5242880) {
                    e.preventDefault();
                    alert('Ukuran gambar terlalu besar! Maksimal 5MB');
                    return false;
                }

                // Cek ekstensi file
                const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                const fileName = file.name.toLowerCase();
                const fileExtension = fileName.split('.').pop();

                if (!allowedExtensions.includes(fileExtension)) {
                    e.preventDefault();
                    alert('Format gambar tidak valid! Gunakan JPG, JPEG, PNG, atau GIF');
                    return false;
                }
            }
        });

        // Konfirmasi sebelum submit jika ada gambar baru
        document.getElementById('formProgram').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('gambar');
            if (fileInput.files.length > 0) {
                const confirmed = confirm('Anda akan mengganti gambar program. Gambar lama akan dihapus. Lanjutkan?');
                if (!confirmed) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    </script>
</body>

</html>