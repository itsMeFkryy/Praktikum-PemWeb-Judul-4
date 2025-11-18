<?php
session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu!";
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Nama harus diisi";
    }
    
    if (empty($phone)) {
        $errors[] = "Nomor telepon harus diisi";
    } elseif (!preg_match('/^[0-9+\-\s]+$/', $phone)) {
        $errors[] = "Format nomor telepon tidak valid";
    }
    
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }
    
    if (empty($errors)) {
        $_SESSION['contacts'][] = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address
        ];
        
        $_SESSION['success'] = "Kontak berhasil ditambahkan!";
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }
}

header('Location: dashboard.php');
exit;
?>