<!doctype html>
<html class="no-js" lang="en">

<?php
include '../dbconnect.php';
include '../cek.php';
if ($role !== 'Admin') {
    header("location:../login.php");
}
?>

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="../favicon.png">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Formulir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144808195-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-144808195-1');
    </script>

    <!-- others css -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
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