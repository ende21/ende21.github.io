<?php
session_start();
include '../../config/conn_db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../../login.php");
    exit;
}

// Cek apakah ada parameter id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Konversi ke integer untuk keamanan

    // Query delete
    $query = "DELETE FROM berita WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        // Berhasil dihapus
        $_SESSION['message'] = "Berita berhasil dihapus!";
        $_SESSION['message_type'] = "success";
    } else {
        // Gagal dihapus
        $_SESSION['message'] = "Gagal menghapus berita: " . mysqli_error($conn);
        $_SESSION['message_type'] = "danger";
    }
} else {
    $_SESSION['message'] = "ID berita tidak ditemukan!";
    $_SESSION['message_type'] = "warning";
}

// Redirect kembali ke halaman kelola berita
header("Location: list.php");
exit;
