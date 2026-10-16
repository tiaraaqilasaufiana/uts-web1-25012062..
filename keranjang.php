
<?php
require_once __DIR__ . '/includes/fungsi.php';
require_once __DIR__ . '/data/menu.php';

$keranjang = $_SESSION['keranjang'] ?? [];

$judulHalaman = 'Keranjang Belanja';
require __DIR__ . '/includes/header.php';
?>

<section class="panel">
    <h2>Keranjang Pesanan</h2>

    <?php if (empty($keranjang)): ?>
        <p class="alert info">
            Keranjang masih kosong.
            Silakan pilih menu dari
            <a href="index.php">daftar menu</a>.
        </p>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($keranjang as $kode => $item): ?>
                        <?php
                        if (!isset($menu[$kode])) {
                            continue;
                        }

                        $data = $menu[$kode];
                        ?>

                        <tr>
                            <td><?= e($kode) ?></td>
                            <td><?= e($data['nama']) ?></td>
                            <td><?= e(rupiah($data['harga'])) ?></td>
                            <td><?= e($item['jumlah']) ?></td>
                            <td>
                                <form
                                    method="post"
                                    action="proses.php"
                                    onsubmit="return confirm('Hapus item ini?')"
                                >
                                    <input
                                        type="hidden"
                                        name="aksi"
                                        value="hapus"
                                    >

                                    <input
                                        type="hidden"
                                        name="kode"
                                        value="<?= e($kode) ?>"
                                    >

                                    <button
                                        class="danger"
                                        type="submit"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <form
            method="post"
            action="proses.php"
            onsubmit="return confirm('Kosongkan seluruh keranjang?')"
        >
            <input
                type="hidden"
                name="aksi"
                value="kosongkan"
            >

            <button class="danger" type="submit">
                Kosongkan Keranjang
            </button>
        </form>
    <?php endif; ?>

    <p>
        <a class="button" href="index.php">
            Kembali ke Daftar Menu
        </a>
    </p>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
