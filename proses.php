
<?php
require_once __DIR__ . '/includes/fungsi.php';
require_once __DIR__ . '/data/menu.php';

// Hanya menerima request POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$aksi = isset($_POST['aksi']) && is_string($_POST['aksi'])
    ? $_POST['aksi']
    : '';

if (!isset($_SESSION['keranjang']) || !is_array($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Menambahkan menu.
if ($aksi === 'tambah') {
    $kode = isset($_POST['kode']) && is_string($_POST['kode'])
        ? $_POST['kode']
        : '';

    if (!isset($menu[$kode])) {
        setFlash('Kode menu tidak valid.', 'error');
        redirect('index.php');
    }

    $jumlahRaw = $_POST['jumlah'] ?? null;

    if (
        !is_string($jumlahRaw) ||
        !preg_match('/^\d+$/', $jumlahRaw)
    ) {
        setFlash('Jumlah harus berupa bilangan bulat.', 'error');
        redirect('index.php');
    }

    $jumlah = (int) $jumlahRaw;

    if ($jumlah < 1 || $jumlah > 10) {
        setFlash('Jumlah pesanan harus antara 1 sampai 10.', 'error');
        redirect('index.php');
    }

    $jumlahLama = isset($_SESSION['keranjang'][$kode]['jumlah'])
        ? (int) $_SESSION['keranjang'][$kode]['jumlah']
        : 0;

    if ($jumlahLama + $jumlah > 10) {
        setFlash(
            'Jumlah menu yang sama tidak boleh lebih dari 10.',
            'error'
        );
        redirect('keranjang.php');
    }

    $_SESSION['keranjang'][$kode] = [
        'jumlah' => $jumlahLama + $jumlah
    ];

    setFlash($menu[$kode]['nama'] . ' berhasil ditambahkan.');
    redirect('keranjang.php');
}

// Menghapus satu item.
if ($aksi === 'hapus') {
    $kode = isset($_POST['kode']) && is_string($_POST['kode'])
        ? $_POST['kode']
        : '';

    if (isset($_SESSION['keranjang'][$kode])) {
        unset($_SESSION['keranjang'][$kode]);
        setFlash('Menu berhasil dihapus dari keranjang.');
    } else {
        setFlash('Menu tidak ditemukan di keranjang.', 'error');
    }

    redirect('keranjang.php');
}

// Mengosongkan seluruh keranjang.
if ($aksi === 'kosongkan') {
    $_SESSION['keranjang'] = [];

    setFlash('Keranjang berhasil dikosongkan.');
    redirect('keranjang.php');
}

setFlash('Aksi tidak dikenal.', 'error');
redirect('index.php');
