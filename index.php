
<?php
require_once __DIR__ . '/includes/fungsi.php';
require_once __DIR__ . '/data/menu.php';

// Ambil kategori yang tersedia dari data menu.
$kategoriTersedia = [];

foreach ($menu as $item) {
    if (!in_array($item['kategori'], $kategoriTersedia, true)) {
        $kategoriTersedia[] = $item['kategori'];
    }
}

// Simpan kategori favorit ke cookie.
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    ($_POST['aksi'] ?? '') === 'simpan_kategori'
) {
    $kategori = isset($_POST['kategori_favorit'])
        && is_string($_POST['kategori_favorit'])
        ? $_POST['kategori_favorit']
        : '';

    if (in_array($kategori, $kategoriTersedia, true)) {
        setcookie('kategori_favorit', $kategori, [
            'expires' => time() + (7 * 24 * 60 * 60),
            'path' => '/',
            'samesite' => 'Lax',
        ]);

        setFlash('Kategori favorit berhasil disimpan selama 7 hari.');
    } else {
        setFlash('Kategori favorit tidak valid.', 'error');
    }

    redirect('index.php');
}

// Prioritas: kategori GET yang valid, lalu cookie yang valid.
$kategoriDipilih = '';

if (
    isset($_GET['kategori']) &&
    is_string($_GET['kategori']) &&
    in_array($_GET['kategori'], $kategoriTersedia, true)
) {
    $kategoriDipilih = $_GET['kategori'];
} elseif (
    isset($_COOKIE['kategori_favorit']) &&
    is_string($_COOKIE['kategori_favorit']) &&
    in_array($_COOKIE['kategori_favorit'], $kategoriTersedia, true)
) {
    $kategoriDipilih = $_COOKIE['kategori_favorit'];
}

// Pencarian nama menu.
$kataKunci = isset($_GET['cari']) && is_string($_GET['cari'])
    ? trim($_GET['cari'])
    : '';

$daftarTampil = [];

foreach ($menu as $kode => $item) {
    $cocokNama = $kataKunci === ''
        || stripos($item['nama'], $kataKunci) !== false;

    $cocokKategori = $kategoriDipilih === ''
        || $item['kategori'] === $kategoriDipilih;

    if ($cocokNama && $cocokKategori) {
        $daftarTampil[$kode] = $item;
    }
}

$judulHalaman = 'Daftar Menu';
require __DIR__ . '/includes/header.php';
?>

<section class="panel">
    <h2>Selamat Datang di Kantin Kampus</h2>
    <p>
        Cari makanan atau minuman favorit dan tambahkan
        pesanan ke keranjang.
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

        <?php if ($kategoriDipilih !== ''): ?>
            <input
                type="hidden"
                name="kategori"
                value="<?= e($kategoriDipilih) ?>"
            >
        <?php endif; ?>

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
    <h2>Preferensi Kategori</h2>

    <form method="post" action="index.php">
        <input type="hidden" name="aksi" value="simpan_kategori">

        <label for="kategori_favorit">
            Simpan kategori favorit selama 7 hari
        </label>

        <select
            id="kategori_favorit"
            name="kategori_favorit"
            required
        >
            <?php foreach ($kategoriTersedia as $kategori): ?>
                <option
                    value="<?= e($kategori) ?>"
                    <?= $kategoriDipilih === $kategori ? 'selected' : '' ?>
                >
                    <?= e($kategori) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Simpan Favorit</button>
    </form>

    <p>
        Kategori aktif:
        <strong>
            <?= e(
                $kategoriDipilih === ''
                    ? 'Semua kategori'
                    : $kategoriDipilih
            ) ?>
        </strong>
    </p>

    <?php if ($kategoriDipilih !== ''): ?>
        <p>
            <a href="index.php">Tampilkan semua kategori</a>
        </p>
    <?php endif; ?>
</section>

<section class="panel">
    <h2>Daftar Menu</h2>

    <?php if (empty($daftarTampil)): ?>
        <p class="alert error">
            Menu tidak ditemukan. Silakan coba kata kunci
            atau kategori lain.
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
                            <td><?= e(rupiah((int) $item['harga'])) ?></td>
                            <td>
                                <form method="post" action="proses.php">
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

                                    <button type="submit">Tambah</button>
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
