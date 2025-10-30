<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

include '../config/conn_db.php';

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$nama = $_SESSION['nama'];

// Ambil data user login
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// ====== PROSES UPDATE PROFIL ======
if (isset($_POST['update_profil'])) {
    $nama_baru = mysqli_real_escape_string($conn, $_POST['nama']);
    $email_baru = mysqli_real_escape_string($conn, $_POST['email']);

    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email_baru' AND id != $user_id");

    if (mysqli_num_rows($check_email) > 0) {
        $_SESSION['message'] = "Email sudah digunakan user lain!";
        $_SESSION['message_type'] = "danger";
    } else {
        $update = "UPDATE users SET nama='$nama_baru', email='$email_baru' WHERE id=$user_id";
        if (mysqli_query($conn, $update)) {
            $_SESSION['nama'] = $nama_baru;
            $_SESSION['message'] = "Profil berhasil diupdate!";
            $_SESSION['message_type'] = "success";
            header("Location: profile.php");
            exit;
        } else {
            $_SESSION['message'] = "Gagal update profil!";
            $_SESSION['message_type'] = "danger";
        }
    }
}

// ====== PROSES GANTI PASSWORD ======
if (isset($_POST['ganti_password'])) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    if (!password_verify($password_lama, $user['password'])) {
        $_SESSION['message'] = "Password lama salah!";
        $_SESSION['message_type'] = "danger";
    } elseif (strlen($password_baru) < 8) {
        $_SESSION['message'] = "Password baru minimal 8 karakter!";
        $_SESSION['message_type'] = "danger";
    } elseif ($password_baru !== $konfirmasi_password) {
        $_SESSION['message'] = "Konfirmasi password tidak cocok!";
        $_SESSION['message_type'] = "danger";
    } else {
        $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
        $update = "UPDATE users SET password='$password_hash' WHERE id=$user_id";
        if (mysqli_query($conn, $update)) {
            $_SESSION['message'] = "Password berhasil diubah!";
            $_SESSION['message_type'] = "success";
            header("Location: profile.php");
            exit;
        } else {
            $_SESSION['message'] = "Gagal mengubah password!";
            $_SESSION['message_type'] = "danger";
        }
    }
}

// ====== [KHUSUS PENGURUS] TAMBAH USER BARU (POST KE DATABASE SAMA SEPERTI register.php) ======
if ($role == 'pengurus' && isset($_POST['register_user'])) {
    $nama_user = mysqli_real_escape_string($conn, $_POST['nama_user']);
    $email_user = mysqli_real_escape_string($conn, $_POST['email_user']);
    $password_user = $_POST['password_user'];
    $role_user = mysqli_real_escape_string($conn, $_POST['role_user']);

    // Cek apakah email sudah ada
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email_user'");

    if (mysqli_num_rows($check) > 0) {
        $_SESSION['message'] = "Email sudah terdaftar!";
        $_SESSION['message_type'] = "danger";
    } elseif (strlen($password_user) < 8) {
        $_SESSION['message'] = "Password minimal 8 karakter!";
        $_SESSION['message_type'] = "danger";
    } else {
        $password_hash = password_hash($password_user, PASSWORD_DEFAULT);
        $insert = "INSERT INTO users (nama, email, password, role, created_at)
                   VALUES ('$nama_user', '$email_user', '$password_hash', '$role_user', NOW())";
        if (mysqli_query($conn, $insert)) {
            $_SESSION['message'] = "User baru berhasil didaftarkan!";
            $_SESSION['message_type'] = "success";
            header("Location: profile.php");
            exit;
        } else {
            $_SESSION['message'] = "Gagal mendaftarkan user!";
            $_SESSION['message_type'] = "danger";
        }
    }
}

// ====== [KHUSUS PENGURUS] HAPUS USER ======
if ($role == 'pengurus' && isset($_GET['hapus_user'])) {
    $id_hapus = intval($_GET['hapus_user']);
    if ($id_hapus == $user_id) {
        $_SESSION['message'] = "Tidak dapat menghapus akun sendiri!";
        $_SESSION['message_type'] = "danger";
    } else {
        $delete = "DELETE FROM users WHERE id = $id_hapus";
        if (mysqli_query($conn, $delete)) {
            $_SESSION['message'] = "User berhasil dihapus!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Gagal menghapus user!";
            $_SESSION['message_type'] = "danger";
        }
    }
    header("Location: profile.php");
    exit;
}

// ====== [KHUSUS PENGURUS] AMBIL SEMUA USER ======
if ($role == 'pengurus') {
    $all_users_query = "SELECT * FROM users ORDER BY created_at DESC";
    $all_users_result = mysqli_query($conn, $all_users_query);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil | PIKK</title>
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

        .profile-header {
            background: linear-gradient(135deg, #FFD43B 0%, #ffce33 100%);
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            color: #FFD43B;
        }

        .profile-info h4 {
            margin: 0;
            font-weight: 600;
        }

        .profile-info p {
            margin: 5px 0 0 0;
            opacity: 0.8;
        }

        .card-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .card-section h5 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
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

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 38px;
            cursor: pointer;
            color: #666;
        }

        .form-group {
            position: relative;
        }

        .user-table-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFD43B, #ffce33);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            margin-right: 10px;
        }

        .badge-role {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-pengurus {
            background-color: #dc3545;
            color: white;
        }

        .badge-volunteer {
            background-color: #0dcaf0;
            color: white;
        }

        .table-actions {
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div><i class="bi bi-circle-fill me-2" style="font-size:0.8rem;"></i>INOVASIKATAKARSA.ID</div>
        <a href="../logout.php" class="text-dark text-decoration-none">Logout</a>
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar d-flex flex-column">
        <a href="index.php" class="menu-item">
            <i class="bi bi-house-door"></i> Dashboard
        </a>

        <?php if ($role == 'pengurus'): ?>
            <a href="berita/list.php" class="menu-item">
                <i class="bi bi-file-earmark-text"></i> Kelola Berita
            </a>
            <a href="rumahbaca/dashboard.php" class="menu-item">
                <i class="bi bi-collection"></i> Kelola Teras Baca
            </a>
        <?php endif; ?>

        <a href="kegiatan/list.php" class="menu-item">
            <i class="bi bi-calendar-event"></i> Kelola Kegiatan
        </a>

        <a href="profil.php" class="menu-item active">
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

            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <?= strtoupper(substr($user['nama'], 0, 1)); ?>
                </div>
                <div class="profile-info">
                    <h4><?= htmlspecialchars($user['nama']); ?></h4>
                    <p><?= htmlspecialchars($user['email']); ?> • <?= ucfirst($user['role']); ?></p>
                </div>
            </div>

            <!-- [KHUSUS PENGURUS] Form Registrasi User Baru -->
            <?php if ($role == 'pengurus'): ?>
                <div class="card-section border border-primary">
                    <h5><i class="bi bi-person-plus-fill me-2 text-primary"></i>Registrasi User Baru</h5>
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text"
                                    class="form-control"
                                    name="nama_user"
                                    required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email"
                                    class="form-control"
                                    name="email_user"
                                    required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password"
                                    class="form-control"
                                    name="password_user"
                                    minlength="8"
                                    required>
                                <small class="text-muted">Min. 8 karakter</small>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label fw-semibold">Role</label>
                                <select class="form-select" name="role_user" required>
                                    <option value="volunteer">Volunteer</option>
                                    <option value="pengurus">Pengurus</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="register_user" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Daftarkan User
                        </button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Form Edit Profil -->
            <div class="card-section">
                <h5><i class="bi bi-person-circle me-2"></i>Informasi Profil</h5>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text"
                                class="form-control"
                                name="nama"
                                value="<?= htmlspecialchars($user['nama']); ?>"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email"
                                class="form-control"
                                name="email"
                                value="<?= htmlspecialchars($user['email']); ?>"
                                required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <input type="text"
                            class="form-control"
                            value="<?= ucfirst($user['role']); ?>"
                            disabled>
                        <small class="text-muted">Role tidak dapat diubah</small>
                    </div>
                    <button type="submit" name="update_profil" class="btn btn-yellow">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Form Ganti Password -->
            <div class="card-section">
                <h5><i class="bi bi-shield-lock me-2"></i>Ubah Password</h5>
                <form method="POST" id="formPassword">
                    <div class="row">
                        <div class="col-md-4 mb-3 form-group">
                            <label class="form-label fw-semibold">Password Lama</label>
                            <input type="password"
                                class="form-control"
                                name="password_lama"
                                id="password_lama"
                                required>
                            <i class="bi bi-eye password-toggle" onclick="togglePassword('password_lama')"></i>
                        </div>
                        <div class="col-md-4 mb-3 form-group">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password"
                                class="form-control"
                                name="password_baru"
                                id="password_baru"
                                minlength="8"
                                required>
                            <i class="bi bi-eye password-toggle" onclick="togglePassword('password_baru')"></i>
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>
                        <div class="col-md-4 mb-3 form-group">
                            <label class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password"
                                class="form-control"
                                name="konfirmasi_password"
                                id="konfirmasi_password"
                                minlength="8"
                                required>
                            <i class="bi bi-eye password-toggle" onclick="togglePassword('konfirmasi_password')"></i>
                        </div>
                    </div>
                    <button type="submit" name="ganti_password" class="btn btn-yellow">
                        <i class="bi bi-key me-1"></i> Ubah Password
                    </button>
                </form>
            </div>

            <!-- [KHUSUS PENGURUS] Daftar Semua User -->
            <?php if ($role == 'pengurus'): ?>
                <div class="card-section">
                    <h5><i class="bi bi-people-fill me-2"></i>Daftar User Terdaftar</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Terdaftar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($u = mysqli_fetch_assoc($all_users_result)): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-table-avatar">
                                                    <?= strtoupper(substr($u['nama'], 0, 1)); ?>
                                                </div>
                                                <div>
                                                    <strong><?= htmlspecialchars($u['nama']); ?></strong>
                                                    <?php if ($u['id'] == $user_id): ?>
                                                        <span class="badge bg-success ms-2">Anda</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($u['email']); ?></td>
                                        <td>
                                            <span class="badge-role <?= $u['role'] == 'pengurus' ? 'badge-pengurus' : 'badge-volunteer'; ?>">
                                                <?= ucfirst($u['role']); ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($u['created_at'])); ?></td>
                                        <td class="text-center table-actions">
                                            <?php if ($u['id'] != $user_id): ?>
                                                <a href="?hapus_user=<?= $u['id']; ?>"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus user <?= htmlspecialchars($u['nama']); ?>?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle show/hide password
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling;

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // Validasi konfirmasi password
        document.getElementById('formPassword').addEventListener('submit', function(e) {
            const passwordBaru = document.getElementById('password_baru').value;
            const konfirmasi = document.getElementById('konfirmasi_password').value;

            if (passwordBaru !== konfirmasi) {
                e.preventDefault();
                alert('Konfirmasi password tidak cocok!');
                return false;
            }
        });
    </script>

</body>

</html>