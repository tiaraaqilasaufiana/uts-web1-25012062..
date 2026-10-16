
<?php
if (!isset($judulHalaman)) {
    $judulHalaman = 'Kantin Kampus';
}

$flash = ambilFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($judulHalaman) ?> - Kantin Kampus</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <h1>Kantin Kampus</h1>
            <nav>
                <a href="index.php">Daftar Menu</a>
                <a href="keranjang.php">Keranjang</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if ($flash !== null): ?>
            <div class="alert <?= e($flash['jenis']) ?>" role="status">
                <?= e($flash['pesan']) ?>
            </div>
        <?php endif; ?>
