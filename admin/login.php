<?php
session_start();
include 'config/conn_db.php'; // Path yang benar sesuai struktur folder

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $login_success = false;

        // Cek password dengan hash
        if (password_verify($password, $user['password'])) {
            $login_success = true;
        }
        // Cek password plain text (data lama)
        elseif ($password === $user['password']) {
            $login_success = true;

            // Auto-update password lama ke hash
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET password='$new_hash' WHERE id=" . $user['id']);
        }

        if ($login_success) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nama'] = $user['nama'];

            header("Location: dashboard/index.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PIKK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
            font-family: 'Poppins', sans-serif;
        }

        /* HEADER BAR */
        .header-bar {
            background-color: #FFDE59;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .header-bar a {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ffffff;
            font-family: 'Caveat Brush', cursive;
            font-size: 1.6rem;
            font-weight: bold;
        }

        .header-bar img {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: white;
            padding: 5px;
            border: 2px solid #ffc107;
        }

        /* LOGIN BOX */
        .login-box {
            width: 400px;
            margin: 120px auto 60px auto;
            border: 1px solid #eee;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* FOOTER */
        .footer-bar {
            background-color: #FFDE59;
            text-align: center;
            padding: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        @media (max-width: 480px) {
            .login-box {
                width: 90%;
                margin-top: 100px;
            }

            .header-bar a {
                font-size: 1.2rem;
            }

            .header-bar img {
                width: 45px;
                height: 45px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER DENGAN LOGO -->
    <div class="header-bar">
        <a href="../Beranda.php">
            <img src="../logo/logo pikk.png" alt="PIKK">
            <span>INOVASIKATAKARSA.ID</span>
        </a>
    </div>

    <!-- LOGIN BOX -->
    <div class="login-box">
        <h5 class="text-center mb-3">LOGIN</h5>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success py-2">
                ✅ Registrasi berhasil! Silakan login.
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger py-2"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control" name="email" required
                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" name="login" class="btn w-100" style="background:#FFD43B; font-weight:600;">LOGIN</button>
        </form>

    </div>

    <div class="footer-bar">©2025 ALL RIGHTS RESERVED | INOVASIKATAKARSA.ID</div>

</body>

</html>