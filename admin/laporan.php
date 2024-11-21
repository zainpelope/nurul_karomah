<?php
include '../dbconnect.php';

// Query untuk mengambil data
$sql = "
    SELECT 
        u.userdataid AS Nomor,
        u.namalengkap AS NamaSiswa,
        u.tglkonfirmasi AS TanggalMendaftar,
        t.tahun_pelajaran AS TahunPelajaran,
        CASE 
            WHEN u.status = 'Verified' THEN 'Diterima'
            WHEN u.status = 'Unverified' THEN 'Belum Diterima'
            ELSE 'Status Tidak Diketahui'
        END AS Status
    FROM userdata u
    LEFT JOIN tahun t ON u.id_tahun = t.id_tahun
    ORDER BY u.tglkonfirmasi DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Data Pendaftar</h2>

        <!-- Filter Dropdown -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="tahunPelajaran" class="form-label">Tahun Pelajaran:</label>
                <select id="tahunPelajaran" class="form-select">
                    <option value="">Pilih Tahun</option>
                    <?php
                    $tahunQuery = "SELECT DISTINCT tahun_pelajaran FROM tahun";
                    $tahunResult = $conn->query($tahunQuery);
                    while ($tahun = $tahunResult->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($tahun['tahun_pelajaran']) . "'>" . htmlspecialchars($tahun['tahun_pelajaran']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="statusFilter" class="form-label">Pilih Status:</label>
                <select id="statusFilter" class="form-select">
                    <option value="">Pilih Status</option>
                    <option value="Diterima">Diterima</option>
                    <option value="Belum Diterima">Belum Diterima</option>
                </select>
            </div>
        </div>

        <!-- Tabel Data -->
        <table id="pendaftarTable" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Tanggal Mendaftar</th>
                    <th>Tahun Pelajaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['NamaSiswa'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['TanggalMendaftar'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['TahunPelajaran'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row['Status'] ?? '') . "</td>";

                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#pendaftarTable').DataTable();

            // Filter berdasarkan Tahun Pelajaran
            $('#tahunPelajaran').on('change', function() {
                table.column(3).search(this.value).draw();
            });

            // Filter berdasarkan Status
            $('#statusFilter').on('change', function() {
                table.column(4).search(this.value).draw();
            });
        });
    </script>
</body>

</html>

<?php
// Tutup koneksi
$conn->close();
?>