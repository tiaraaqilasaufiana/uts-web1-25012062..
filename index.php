
<?php
require_once __DIR__ . '/includes/fungsi.php';
require_once __DIR__ . '/data/menu.php';

$kataKunci = isset($_GET['cari']) && is_string($_GET['cari'])
    ? trim($_GET['cari'])
    : '';

$daftarTampil = [];

foreach ($menu as $kode => $item) {
    if (
        $kataKunci === '' ||
        stripos($item['nama'], $kataKunci) !== false
    ) {
        $daftarTampil[$kode] = $item;
    }
}

$judulHalaman = 'Daftar Menu';
require __DIR__ . '/includes/header.php';
?>

<section class="panel">
    <h2>Selamat Datang di Kantin Kampus</h2>
    <p>
        Silakan cari makanan atau minuman yang ingin dipesan
        dari daftar menu kantin kampus.
    </p>
</section>

<section class="panel">
    <h2>Cari Menu</h2>

    <form method="get" action="index.php">
        <label for="cari">Nama menu</label>

        <input
            type="text"
            id="cari"
            name="cari"
            value="<?= e($kataKunci) ?>"
            placeholder="Contoh: nasi"
        >

        <button type="submit">Cari</button>
        <a class="button secondary" href="index.php">Reset</a>
    </form>

    <p>
        Kata kunci:
        <strong>
            <?= e($kataKunci === '' ? 'Semua menu' : $kataKunci) ?>
        </strong>
    </p>
</section>

<section class="panel">
    <h2>Daftar Menu</h2>

    <?php if (empty($daftarTampil)): ?>
        <p class="alert error">
            Menu tidak ditemukan. Silakan coba kata kunci lain.
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
                        <th>Jumlah dan Pesan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($daftarTampil as $item): ?>
                        <tr>
                            <td><?= e($item['kode']) ?></td>
                            <td><?= e($item['nama']) ?></td>
                            <td><?= e($item['kategori']) ?></td>
                            <td><?= e(rupiah($item['harga'])) ?></td>
                            <td>
                                <form
                                    method="post"
                                    action="proses.php"
                                >
                                    <input
                                        type="hidden"
                                        name="aksi"
                                        value="tambah"
                                    >

                                    <input
                                        type="hidden"
                                        name="kode"
                                        value="<?= e($item['kode']) ?>"
                                    >

                                    <label
                                        for="jumlah-<?= e($item['kode']) ?>"
                                    >
                                        Jumlah
                                    </label>

                                    <input
                                        id="jumlah-<?= e($item['kode']) ?>"
                                        type="number"
                                        name="jumlah"
                                        min="1"
                                        max="10"
                                        step="1"
                                        required
                                    >

                                    <button type="submit">
                                        Tambah
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
