```php
<?php
require_once __DIR__ . '/includes/fungsi.php';
require_once __DIR__ . '/data/menu.php';

// Kerangka awal untuk proses pemesanan.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$judulHalaman = 'Proses Pemesanan';

$aksi = isset($_POST['aksi']) && is_string($_POST['aksi'])
    ? $_POST['aksi']
    : '';

if ($aksi === 'tambah') {
    setFlash('Fitur pemesanan akan dibuat pada tahap berikutnya.');
    redirect('index.php');
}

setFlash('Fitur ini belum tersedia.', 'error');
redirect('index.php');
```
