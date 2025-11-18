<?php
session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu!";
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['contacts'])) {
    $_SESSION['contacts'] = [];
}

if (isset($_GET['id']) && isset($_SESSION['contacts'][$_GET['id']])) {
    $deleted_contact = $_SESSION['contacts'][$_GET['id']];
    array_splice($_SESSION['contacts'], $_GET['id'], 1);
    $_SESSION['success'] = "Kontak '{$deleted_contact['name']}' berhasil dihapus!";
} else {
    $_SESSION['error'] = "Kontak tidak ditemukan!";
}

header('Location: dashboard.php');
exit;
?>