<!doctype html>
<html lang="en">

<?php
include '../dbconnect.php'; // File koneksi database
include '../cek.php'; // File cek login
if ($role !== 'Admin') {
    header("location:../login.php");
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Tahun Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-4">
        <h2>Manajemen Tahun Pendaftaran</h2>

        <!-- Tombol Tambah Tahun -->
        <div class="mb-3">
            <a href="add_tahun.php" class="btn btn-primary">+ Tambah Tahun Pendaftaran</a>
        </div>

        <!-- Tabel Data -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Tahun Pelajaran</th>
                    <th>Batas Pendaftaran</th>
                    <th>Batas Jumlah Pendaftar</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil data tahun dari database
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM tahun ORDER BY tahun_pelajaran DESC");
                while ($row = mysqli_fetch_assoc($query)) {
                    // Tentukan kelas CSS berdasarkan status
                    $statusClass = $row['status'] == 1 ? 'text-success' : 'text-danger';
                    $status = $row['status'] == 1 ? 'Aktif' : 'Nonaktif';

                    echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['tahun_pelajaran']}</td>
                        <td>{$row['tanggal_tutup']}</td>
                        <td>{$row['batas']}</td>
                        <td class='{$statusClass} font-italic fw-bold'>{$status}</td>
                        <td>
                            <a href='edit_tahun.php?tahun={$row['tahun_pelajaran']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_tahun.php?tahun={$row['tahun_pelajaran']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Delete</a>
                        </td>
                    </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</body>

</html>