<?php
session_start();
include '../../config/conn_db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

$role = $_SESSION['role'];
$nama = $_SESSION['nama'];

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

    // Generate slug dari judul
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul)));
    $slug = trim($slug, '-'); // Hapus dash di awal/akhir

    // Cek apakah slug sudah ada
    $check_slug = mysqli_query($conn, "SELECT id FROM programs WHERE slug = '$slug'");
    if (mysqli_num_rows($check_slug) > 0) {
        $slug = $slug . '-' . time(); // Tambahkan timestamp jika sudah ada
    }

    // Upload gambar
    $gambar_name = '';
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

            // Buat folder jika belum ada
            if (!file_exists('../../../pict/')) {
                mkdir('../../../pict/', 0777, true);
            }

            // Cek apakah file sudah ada (untuk safety)
            while (file_exists($upload_path)) {
                $next_number++;
                $gambar_name = 'gambar' . $next_number . '.' . $ext;
                $upload_path = '../../../pict/' . $gambar_name;
            }

            if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
                $errors[] = 'Gagal upload gambar. Pastikan folder pict/ memiliki permission yang benar';
            }
        }
    } else {
        if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] == 4) {
            $errors[] = 'Gambar harus diupload';
        } else {
            $errors[] = 'Error upload gambar: ' . $_FILES['gambar']['error'];
        }
    }

    // Insert ke database jika tidak ada error
    if (empty($errors) && !empty($gambar_name)) {
        $query = "INSERT INTO programs (kategori, judul, tanggal, lokasi, deskripsi, gambar, slug, status, created_at) 
                 VALUES ('$kategori', '$judul', '$tanggal', '$lokasi', '$deskripsi', '$gambar_name', '$slug', 'aktif', NOW())";

        if (mysqli_query($conn, $query)) {
            $_SESSION['message'] = 'Program berhasil ditambahkan!';
            $_SESSION['message_type'] = 'success';
            header('Location: list.php');
            exit;
        } else {
            $errors[] = 'Error database: ' . mysqli_error($conn);
            // Hapus gambar jika gagal insert
            if (file_exists('../../../pict/' . $gambar_name)) {
                unlink('../../../pict/' . $gambar_name);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Program | PIKK</title>
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
                <i class="bi bi-collection"></i> Kelola Teras Baca 
            </a>
        <?php endif; ?>

        <a href="list.php" class="menu-item active">
            <i class="bi bi-calendar-event"></i> Kelola Kegiatan
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
                    <i class="bi bi-plus-circle me-2"></i>Tambah Program Baru
                </h4>
                <a href="list.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form method="POST" enctype="multipart/form-data" id="formProgram">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">
                            Kategori Program <span class="required">*</span>
                        </label>
                        <select name="kategori" id="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="pikk" <?php echo (isset($_POST['kategori']) && $_POST['kategori'] == 'pikk') ? 'selected' : ''; ?>>PIKK</option>
                            <option value="kolaborasi" <?php echo (isset($_POST['kategori']) && $_POST['kategori'] == 'kolaborasi') ? 'selected' : ''; ?>>Kolaborasi</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label">
                            Tanggal Pelaksanaan <span class="required">*</span>
                        </label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control"
                            value="<?php echo isset($_POST['tanggal']) ? $_POST['tanggal'] : ''; ?>" required>
                        <div class="hint-text">Pilih tanggal pelaksanaan program</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="judul" class="form-label">
                        Judul Program <span class="required">*</span>
                    </label>
                    <input type="text" name="judul" id="judul" class="form-control"
                        placeholder="Contoh: Baca Buku Bareng PIKK dan Novo Club Pontianak"
                        value="<?php echo isset($_POST['judul']) ? htmlspecialchars($_POST['judul']) : ''; ?>"
                        required>
                    <div class="hint-text">Masukkan judul program yang menarik dan deskriptif</div>
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">
                        Lokasi <span class="required">*</span>
                    </label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control"
                        placeholder="Contoh: SDN 01 Sukamulya"
                        value="<?php echo isset($_POST['lokasi']) ? htmlspecialchars($_POST['lokasi']) : ''; ?>"
                        required>
                    <div class="hint-text">Lokasi tempat program dilaksanakan</div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">
                        Deskripsi Program <span class="required">*</span>
                    </label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control"
                        placeholder="Jelaskan tujuan dan manfaat program..."
                        required><?php echo isset($_POST['deskripsi']) ? htmlspecialchars($_POST['deskripsi']) : ''; ?></textarea>
                    <div class="hint-text">Jelaskan tujuan, manfaat, dan kegiatan yang akan dilakukan dalam program ini</div>
                </div>

                <div class="mb-4">
                    <label for="gambar" class="form-label">
                        Gambar Program <span class="required">*</span>
                    </label>
                    <input type="file" name="gambar" id="gambar" class="form-control"
                        accept="image/jpeg,image/jpg,image/png,image/gif" required>
                    <div class="hint-text">
                        <i class="bi bi-info-circle me-1"></i>
                        Format: JPG, JPEG, PNG, GIF | Maksimal 5MB | Resolusi minimal 800x600px
                    </div>

                    <!-- Preview Gambar -->
                    <div class="image-preview" id="imagePreview">
                        <p class="mt-2 mb-2"><strong>Preview:</strong></p>
                        <img id="previewImg" src="" alt="Preview">
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-lightbulb me-2"></i>
                    <strong>Tips:</strong> Pastikan semua data sudah benar sebelum menyimpan.
                    Program yang disimpan akan langsung aktif dan tampil di website.
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-yellow">
                        <i class="bi bi-save me-1"></i> Simpan Program
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
        // Preview gambar sebelum upload
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // Validasi form sebelum submit
        document.getElementById('formProgram').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('gambar');
            const file = fileInput.files[0];

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
    </script>
</body>

</html>