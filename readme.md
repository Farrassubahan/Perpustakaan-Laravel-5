# L Farpus - Sistem Informasi Perpustakaan

Sistem manajemen perpustakaan yang profesional dan ringkas, dibangun menggunakan **Laravel 5.3**. Proyek ini dibuat khusus sebagai sumber pembelajaran untuk mendalami arsitektur MVC (Model-View-Controller) pada framework Laravel.

## 🎯 Tujuan Pembelajaran

Proyek ini ditujukan untuk **tujuan edukasi**, dengan fokus pada:
-   **Kemampuan Laravel 5.3**: Memahami struktur dan ketahanan Laravel versi 5.3 dalam jangka panjang.
-   **Operasi CRUD**: Mengelola data buku, kategori, dan pengguna secara efisien.
-   **Logika Bisnis**: Implementasi sistem perpustakaan nyata seperti pemantauan stok real-time dan pelacakan peminjaman.
-   **Integrasi Frontend**: Menggabungkan Bootstrap 3 dan Font Awesome dengan Blade template yang dinamis untuk pengalaman pengguna yang premium.

## 🚀 Fitur Utama

-   **Halaman Utama Dinamis**: Menampilkan koleksi buku terbaru secara real-time dari database.
-   **Manajemen Buku**: Kontrol penuh atas judul, penulis, dan inventaris buku.
-   **Sistem Peminjaman**: Pelacakan status otomatis (Tersedia vs Dipinjam).
-   **Antarmuka Responsif**: Dashboard dan landing page modern menggunakan grid Bootstrap dan Font Awesome.

## 🛠️ Teknologi yang Digunakan

-   **Backend**: PHP 7.x / Laravel 5.3
-   **Frontend**: Blade Template Engine, Bootstrap 3, Font Awesome 4.7
-   **Arsitektur**: Model-View-Controller (MVC)

## 📦 Cara Instalasi

1.  **Instal Dependensi**:
    ```bash
    composer install
    ```
2.  **Pengaturan Environment**:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
3.  **Konfigurasi Database**: Sesuaikan pengaturan database di file `.env`, lalu jalankan:
    ```bash
    php artisan migrate
    ```
4.  **Jalankan Aplikasi**:
    ```bash
    php artisan serve
    ```

---
*Dibuat sebagai bagian dari perjalanan belajar untuk mendemonstrasikan praktik pemrograman yang bersih (clean code) di Laravel.*
