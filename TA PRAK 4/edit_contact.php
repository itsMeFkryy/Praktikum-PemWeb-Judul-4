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

$contacts = $_SESSION['contacts'];

if (!isset($_GET['id']) || !isset($contacts[$_GET['id']])) {
    $_SESSION['error'] = "Kontak tidak ditemukan!";
    header('Location: dashboard.php');
    exit;
}

$id = $_GET['id'];
$contact = $contacts[$id];

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
        $_SESSION['contacts'][$id] = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address
        ];
        
        $_SESSION['success'] = "Kontak berhasil diperbarui!";
        header('Location: dashboard.php');
        exit;
    } else {
        $_SESSION['error'] = implode("<br>", $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kontak - Sistem Manajemen Kontak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">

            <header class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold text-indigo-700">Edit Kontak</h1>
                    <a href="dashboard.php" class="text-indigo-600 hover:text-indigo-800 inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </header>

            <div class="bg-white rounded-xl shadow-md p-6">
                <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="name" name="name" required 
                            value="<?= htmlspecialchars($contact['name']) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                            placeholder="Masukkan nama lengkap">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon *</label>
                        <input type="text" id="phone" name="phone" required 
                            value="<?= htmlspecialchars($contact['phone']) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                            placeholder="Contoh: 08123456789">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" 
                            value="<?= htmlspecialchars($contact['email']) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                            placeholder="nama@contoh.com">
                    </div>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <input type="text" id="address" name="address" 
                            value="<?= htmlspecialchars($contact['address']) ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                            placeholder="Masukkan alamat lengkap">
                    </div>
                    
                    <div class="md:col-span-2 flex space-x-4">
                        <button type="submit" 
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                        <a href="dashboard.php" 
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>