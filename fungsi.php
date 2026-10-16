<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e($nilai): string {
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}

function rupiah(int $nilai): string {
    return 'Rp' . number_format($nilai, 0, ',', '.');
}

function hitungSubtotalItem(int $harga, int $jumlah): int {
    return $harga * $jumlah;
}

function hitungSubtotalKeranjang(array $keranjang, array $menu): int {
    $total = 0;
    foreach ($keranjang as $kode => $item) {
        if (isset($menu[$kode])) {
            $total += hitungSubtotalItem((int)$menu[$kode]['harga'], (int)$item['jumlah']);
        }
    }
    return $total;
}

function hitungDiskon(int $subtotal): int {
    return $subtotal >= 50000 ? (int) round($subtotal * 0.10) : 0;
}

function hitungTotalAkhir(int $subtotal): int {
    return $subtotal - hitungDiskon($subtotal);
}

function setFlash(string $pesan, string $jenis = 'success'): void {
    $_SESSION['flash'] = ['pesan' => $pesan, 'jenis' => $jenis];
}

function ambilFlash(): ?array {
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function redirect(string $tujuan): void {
    header('Location: ' . $tujuan);
    exit;
}
