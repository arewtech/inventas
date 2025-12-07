# Inventas

[Inventas](https://github.com/arewtech/inventas.git) adalah platform layanan pembuatan surat digital yang dirancang khusus untuk Yayasan Al-Khairiyah.

## Preview Website

Preview Homepage

![Inventas](/public/assets/preview/homepage.png)

Preview Dashboard

![Inventas](/public/assets/preview/dashboard.png)

## Fitur

### Manajemen Aset

-   **Management Asset** - Pengelolaan data aset sekolah (kategori, lokasi, kondisi)
-   **Asset Borrowing** - Sistem peminjaman aset dengan tracking status
-   **QR Code Generator** - Generate QR code untuk setiap aset
-   **Report Asset** - Laporan aset dan riwayat peminjaman

### Layanan Surat Digital

-   **Surat Keterangan Masuk** - Pengajuan dan pengelolaan surat keterangan pindah masuk siswa
-   **Surat Keterangan Keluar** - Pengajuan dan pengelolaan surat keterangan pindah keluar siswa
-   **Surat Keterangan Aktif Mengajar** - Pengajuan dan pengelolaan surat keterangan aktif mengajar guru
-   **Dashboard Admin** - Pengelolaan dan persetujuan surat
-   **Cetak Surat** - Template cetak surat dengan kop resmi
-   **Riwayat Pengajuan** - Tracking status pengajuan surat

### Sistem

-   **Multi Role** - Admin, Operator, dan User
-   **Dashboard Analytics** - Statistik dan grafik untuk monitoring

## Instalasi

-   Install [Composer](https://getcomposer.org/download) dan [Npm](https://nodejs.org/en/download)
-   Clone repository: `git clone https://github.com/arewtech/inventas.git inventas`
-   Masuk ke direktori project: `cd inventas`
-   Install dependencies: `composer install`
-   Copy file environment: `cp .env.example .env`
-   Generate application key: `php artisan key:generate`
-   Konfigurasi database di file `.env`
-   Jalankan migration: `php artisan migrate --seed`
-   Buat symlink storage: `php artisan storage:link`
-   Jalankan aplikasi: `php artisan serve`

## Penggunaan

-   **Admin/Operator**:
    -   Login dengan akun yang sudah ada atau gunakan akun default dari seeder
    -   Akses `/dashboard` untuk mengelola surat, aset, dan peminjaman
    -   Kelola kategori dan lokasi aset
    -   Generate QR code dan cetak untuk setiap aset
    -   Monitor peminjaman aset dan status pengembalian
    -   Lihat report aset dan riwayat peminjaman
-   **User**:
    -   Daftar akun baru melalui halaman register
    -   Ajukan surat melalui menu Letters
    -   Lihat riwayat pengajuan surat di menu Histories

## Role & Akses

-   **Admin & Operator**:
    -   Akses penuh ke dashboard
    -   Kelola aset (tambah, edit, hapus)
    -   Kelola peminjaman aset
    -   Kelola dan setujui semua surat
    -   Lihat report dan analitik
    -   Kelola kategori, lokasi, dan operator
-   **User**:
    -   Hanya dapat mengajukan surat
    -   Melihat riwayat pengajuan sendiri
    -   Tidak dapat akses dashboard admin
