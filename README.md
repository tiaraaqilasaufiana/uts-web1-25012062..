**# UTS Web I - Pemesanan Kantin Kampus**

**\*Nama:\*** Tiara Aqila Saufiana  
**\*NIM:\*** 25012062  
**\*Kelas:\*** 25M31

**## Deskripsi**

Aplikasi Pemesanan Kantin Kampus menggunakan PHP native. Menu disimpan dalam array PHP, sedangkan keranjang menggunakan session. Aplikasi mendukung pencarian GET, pemesanan POST, validasi jumlah, hapus item, kosongkan keranjang, diskon 10% untuk subtotal minimal Rp50.000, flash message, pola Post/Redirect/Get, dan preferensi kategori menggunakan cookie selama 7 hari.

**## Kebutuhan**

- XAMPP dengan Apache
- PHP yang disertakan bersama XAMPP
- Browser web
- Git untuk version control

**## Cara menjalankan**

1. Salin folder project ke `C:\xampp\htdocs\uts-web1-25012062`.
2. Jalankan Apache dari XAMPP Control Panel.
3. Buka http://localhost/uts-web1-25012062/.
4. Tidak memerlukan database.

**# Dokumentasi Pengujian**

**## Identitas**

- Nama: Tiara Aqila Saufiana
- NIM: 25012062
- Kelas: 25M31

**## Hasil Pengujian**

| ID | Langkah dan Input | Hasil yang Diharapkan | Hasil Aktual | Status | Bukti |
|---|---|---|---|---|---|
| U01 | Buka halaman menu | Minimal 5 menu tampil | 5 menu tampil | Lulus | [Screenshot](U01-daftar-menu.png) |
| U02a | Cari "Nasi Goreng" | Menu yang sesuai tampil | Nasi Goreng tampil | Lulus | [Screenshot](U02a-pencarian-ditemukan.png) |
| U02b | Cari "Pizza" | Pesan tidak ditemukan | Pesan tidak ditemukan tampil | Lulus | [Screenshot](U02b-pencarian-kosong.png) |
| U03a | Kirim jumlah kosong | Ditolak, keranjang tetap | Pesan kesalahan tampil, keranjang tetap | Lulus | [Screenshot](U03a-jumlah-kosong.png) |
| U08a | Buat subtotal Rp49.000 | Diskon Rp0, total Rp49.000 | Sesuai harapan | Lulus | [Screenshot](U08a-subtotal-49000.png) |
| U08b | Buat subtotal Rp50.000 | Diskon Rp5.000, total Rp45.000 | Diskon belum diterapkan | Gagal | [Screenshot](U08b-diskon-gagal.png) |
| U08b-ulang | Uji ulang setelah perbaikan | Diskon Rp5.000, total Rp45.000 | Sesuai harapan | Lulus | [Screenshot](U08b-diskon-perbaikan.png) |
| U09 | Uji preferensi kategori menggunakan cookie | Preferensi kategori tersimpan selama 7 hari | Isi sesuai hasil pengujian cookie | Lulus jika berhasil | [Screenshot](U09-cookie-kategori.png) |

**## Catatan Perbaikan**

- U08b: kondisi diskon diperbaiki agar berlaku ketika subtotal sama dengan atau lebih dari Rp50.000.
- Pengujian ulang berhasil.
- U09: pengujian preferensi kategori menggunakan cookie dilakukan untuk memeriksa penyimpanan preferensi kategori selama 7 hari.