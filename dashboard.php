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
$username = $_SESSION['username'];
$login_time = $_SESSION['login_time'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Manajemen Kontak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-10">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-indigo-700 mb-2">Sistem Manajemen Kontak</h1>
                    <p class="text-gray-600">Kelola kontak Anda dengan mudah dan efisien</p>
                </div>
                <div class="text-right">
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600">
                            <div class="font-medium">Halo, <?= htmlspecialchars($username) ?>!</div>
                            <div class="text-xs">Login: <?= date('d/m/Y H:i', $login_time) ?></div>
                        </div>
                        <a href="logout.php" 
                           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition duration-200 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4 max-w-md">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4 max-w-md">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                </div>
            <?php endif; ?>
        </header>

        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Kontak Baru</h2>
                
                <form action="add_contact.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="name" name="name" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                            placeholder="Masukkan nama lengkap">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon *</label>
                        <input type="text" id="phone" name="phone" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                            placeholder="Contoh: 08123456789">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                            placeholder="nama@contoh.com">
                    </div>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <input type="text" id="address" name="address" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                            placeholder="Masukkan alamat lengkap">
                    </div>
                    
                    <div class="md:col-span-2">
                        <button type="submit" 
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Tambah Kontak
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Daftar Kontak</h2>
                    <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full">
                        <?= count($contacts) ?> Kontak
                    </span>
                </div>
                
                <?php if (empty($contacts)): ?>
                    <div class="text-center py-12">
                        <i class="fas fa-address-book text-5xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg">Belum ada kontak yang tersimpan</p>
                        <p class="text-gray-400 mt-2">Tambahkan kontak pertama Anda di atas</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 border-b">
                                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Nama</th>
                                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Telepon</th>
                                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Email</th>
                                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Alamat</th>
                                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($contacts as $index => $contact): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-indigo-600 font-semibold">
                                                    <?= strtoupper(substr($contact['name'], 0, 1)) ?>
                                                </span>
                                            </div>
                                            <span class="font-medium text-gray-800"><?= htmlspecialchars($contact['name']) ?></span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-600"><?= htmlspecialchars($contact['phone']) ?></td>
                                    <td class="py-3 px-4 text-gray-600">
                                        <?= $contact['email'] ? htmlspecialchars($contact['email']) : '<span class="text-gray-400">-</span>' ?>
                                    </td>
                                    <td class="py-3 px-4 text-gray-600">
                                        <?= $contact['address'] ? htmlspecialchars($contact['address']) : '<span class="text-gray-400">-</span>' ?>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex space-x-2">
                                            <a href="edit_contact.php?id=<?= $index ?>" 
                                               class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-lg text-sm transition duration-200 flex items-center">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            <a href="delete_contact.php?id=<?= $index ?>" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus kontak ini?')"
                                               class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded-lg text-sm transition duration-200 flex items-center">
                                                <i class="fas fa-trash mr-1"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-8 text-center text-gray-500 text-sm">
                <p>Sistem Manajemen Kontak Praktikum Pemrograman Web Teknik Informatika Unila &copy; <?= date('Y') ?> - User: <?= htmlspecialchars($username) ?> - Login: <?= date('d/m/Y H:i', $login_time) ?></p>
            </div>
        </div>
    </div>
</body>
</html>