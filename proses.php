
<?php
require_once __DIR__ . '/includes/fungsi.php';
require_once __DIR__ . '/data/menu.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$aksi = isset($_POST['aksi']) && is_string($_POST['aksi'])
    ? $_POST['aksi']
    : '';

if ($aksi !== 'tambah') {
    setFlash('Aksi tidak dikenal.', 'error');
    redirect('index.php');
}

// Validasi kode menu.
$kode = isset($_POST['kode']) && is_string($_POST['kode'])
    ? $_POST['kode']
    : '';

if (!isset($menu[$kode])) {
    setFlash('Kode menu tidak valid.', 'error');
    redirect('index.php');
}

// Validasi jumlah pesanan.
$jumlahRaw = $_POST['jumlah'] ?? null;

if (!is_string($jumlahRaw) || !preg_match('/^\d+$/', $jumlahRaw)) {
    setFlash('Jumlah pesanan harus berupa bilangan bulat.', 'error');
    redirect('index.php');
}

$jumlah = (int) $jumlahRaw;

if ($jumlah < 1 || $jumlah > 10) {
    setFlash('Jumlah pesanan harus antara 1 sampai 10.', 'error');
    redirect('index.php');
}

// Simpan pesanan ke session.
if (!isset($_SESSION['keranjang']) || !is_array($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

$jumlahLama = isset($_SESSION['keranjang'][$kode]['jumlah'])
    ? (int) $_SESSION['keranjang'][$kode]['jumlah']
    : 0;

if ($jumlahLama + $jumlah > 10) {
    setFlash('Jumlah menu ini di keranjang tidak boleh lebih dari 10.', 'error');
    redirect('index.php');
}

$_SESSION['keranjang'][$kode] = [
    'jumlah' => $jumlahLama + $jumlah
];

setFlash(
    $menu[$kode]['nama'] . ' berhasil ditambahkan ke keranjang.'
);

redirect('index.php');
