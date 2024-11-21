<?php
include '../dbconnect.php';
include '../cek.php';

if ($role !== 'Admin') {
    header("location:../login.php");
}

// Ambil id tahun dari URL
if (isset($_GET['tahun'])) {
    $tahun_pelajaran = $_GET['tahun'];

    // Ambil data tahun berdasarkan tahun yang dipilih
    $query = "SELECT * FROM tahun WHERE tahun_pelajaran = '$tahun_pelajaran'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die("Data tahun tidak ditemukan.");
    }

    // Proses update data tahun
    if (isset($_POST['submit'])) {
        $tahun_pelajaran = $_POST['tahun_pelajaran'];
        $tanggal_tutup = $_POST['tanggal_tutup'];
        $batas = $_POST['batas'];

        // Tentukan status berdasarkan batas pendaftaran
        $currentDate = date('Y-m-d'); // Ambil tanggal saat ini
        if ($currentDate < $tanggal_tutup) {
            $status = 1; // Aktif jika tanggal saat ini lebih kecil dari batas pendaftaran
        } else {
            $status = 0; // Nonaktif jika tanggal saat ini lebih besar atau sama dengan batas pendaftaran
        }

        // Query untuk update data tahun
        $updateQuery = "UPDATE tahun SET tahun_pelajaran = '$tahun_pelajaran', tanggal_tutup = '$tanggal_tutup', batas = '$batas', status = '$status' WHERE tahun_pelajaran = '$tahun_pelajaran'";

        if (mysqli_query($conn, $updateQuery)) {
            header("Location: index.php"); // Redirect setelah berhasil
        } else {
            echo "Gagal memperbarui data: " . mysqli_error($conn);
        }
    }
} else {
    die("Tahun tidak ditemukan.");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Tahun Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-4">
        <h2>Edit Tahun Pendaftaran</h2>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" value="<?= htmlspecialchars($data['tahun_pelajaran']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_tutup" class="form-label">Batas Pendaftaran</label>
                <input type="date" class="form-control" id="tanggal_tutup" name="tanggal_tutup" value="<?= htmlspecialchars($data['tanggal_tutup']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="batas" class="form-label">Batas Jumlah Pendaftar</label>
                <input type="number" class="form-control" id="batas" name="batas" value="<?= htmlspecialchars($data['batas']) ?>" required>
            </div>

            <!-- Status tidak perlu input, akan otomatis diatur berdasarkan batas pendaftaran -->
            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</body>

</html>