<?php
session_start();
include '../../config/conn_db.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../login.php");
    exit;
}

// Cek apakah ada ID yang dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = 'ID program tidak valid!';
    $_SESSION['message_type'] = 'danger';
    header('Location: list.php');
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data program untuk mendapatkan nama file gambar
$query = "SELECT * FROM programs WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    $_SESSION['message'] = 'Program tidak ditemukan!';
    $_SESSION['message_type'] = 'danger';
    header('Location: list.php');
    exit;
}

$program = mysqli_fetch_assoc($result);

// Hapus file gambar jika ada
if (!empty($program['gambar'])) {
    $file_path = '../../../pict/' . $program['gambar'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// Hapus data dari database
$delete_query = "DELETE FROM programs WHERE id = '$id'";

if (mysqli_query($conn, $delete_query)) {
    $_SESSION['message'] = 'Program berhasil dihapus!';
    $_SESSION['message_type'] = 'success';
} else {
    $_SESSION['message'] = 'Gagal menghapus program: ' . mysqli_error($conn);
    $_SESSION['message_type'] = 'danger';
}

header('Location: list.php');
exit;
?>