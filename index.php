
<?php
require_once __DIR__ . '/includes/fungsi.php';
require_once __DIR__ . '/data/menu.php';

$judulHalaman = 'Daftar Menu';

require __DIR__ . '/includes/header.php';
?>

<section class="panel">
    <h2>Selamat Datang di Kantin Kampus</h2>
    <p>
        Aplikasi ini digunakan untuk melihat menu makanan dan minuman
        serta melakukan pemesanan secara online.
    </p>
</section>

<section class="panel">
    <h2>Daftar Menu</h2>

    <?php if (empty($menu)): ?>
        <p class="alert error">
            Belum ada menu yang tersedia.
        </p>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($menu as $item): ?>
                        <tr>
                            <td><?= e($item['kode']) ?></td>
                            <td><?= e($item['nama']) ?></td>
                            <td><?= e($item['kategori']) ?></td>
                            <td><?= e(rupiah($item['harga'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
```