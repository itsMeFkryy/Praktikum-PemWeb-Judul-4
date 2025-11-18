# Praktikum-PemWeb-Judul-4

- Nama : Alfikri Deo Putra
- NPM  : 2315061075

# 📒 Sistem Manajemen Kontak Sederhana

Pada Praktikum Judul 4 ini Membuat Website untuk menyimpan dan mengelola data kontak yang dibuat menggunakan PHP dan Tailwind CSS. Sistem ini memudahkan untuk mencatat informasi kontak seperti nama, nomor telepon, email, dan alamat.

## Penjelasan Kode PHP

### Session Management
File `login.php` mengatur sistem login dengan mengecek username dan password. Data user disimpan di session PHP seperti status login, username, dan waktu login. Setiap halaman dilindungi dengan pengecekan session di awal kode.

### Form Validation
File `add_contact.php` dan `edit_contact.php` menangani validasi input form. Sistem memeriksa apakah nama dan telepon sudah diisi, format telepon hanya angka, dan format email benar jika diisi. Pesan error disimpan di session untuk ditampilkan ke user.

### CRUD Operations
- **Tambah kontak**: Data dari form disimpan ke array dalam session
- **Edit kontak**: Data diupdate berdasarkan index array
- **Hapus kontak**: Data dihapus dari array session menggunakan array_splice()
- **Tampil kontak**: Data dibaca dari session dan ditampilkan dalam tabel

### Data Storage
Semua data kontak disimpan dalam session PHP (`$_SESSION['contacts']`). Setiap kontak berupa array yang berisi nama, telepon, email, dan alamat. Data akan hilang ketika browser ditutup.

### Security Features
- Redirect otomatis ke login jika belum login
- Validasi ID kontak saat edit/hapus
- Escape output dengan htmlspecialchars()
- Session dihancurkan saat logout

### User Interface
Menggunakan Tailwind CSS untuk styling yang responsive. Form layout menyesuaikan layar, tabel kontak bisa di-scroll horizontal di mobile, dan ada feedback visual seperti hover effects dan loading states.
