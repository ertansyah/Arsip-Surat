<?php
session_start(); // Start the session
$jabatan = $_SESSION['jabatan'];
$bidang = $_SESSION['bidang'];
// Check if the user is logged in
if (!isset($_SESSION['nip'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Retrieve user's role and department from session
$jabatan = $_SESSION['jabatan'];
$bidang = $_SESSION['bidang'];

require_once '../../koneksi.php';
$notificationMessage = isset($_GET['notification']) ? $_GET['notification'] : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Jabatan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="../../admin/index.php">
            <img src="../../assets/img/bpkad1.png" alt="BPKAD Logo" style="max-width: 150px; height: auto;" />
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" action="" method="post">
            <div class="input-group">
                <input class="form-control" type="text" name="cari_bidang" placeholder="Cari bidang" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../../logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Utama</div>
                        <a class="nav-link" href="../../admin/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="user.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>
                            Tambah user
                        </a>
                        <a class="nav-link" href="jabatan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-address-card "></i></div>
                            Tambah Jabatan
                        </a>
                        <a class="nav-link" href="bidang.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>
                            Tambah Bidang
                        </a>
                        <a class="nav-link" href="lampiran.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-paperclip"></i></div>
                            Tambah Lampiran
                        </a>
                        <a class="nav-link" href="sifat.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-certificate"></i></div>
                            Tambah Sifat
                        </a>
                        <div class="sb-sidenav-menu-heading"></div>
                    </div>
                </div>

                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <div><?php echo "Jabatan : $jabatan"; ?></div>
                    <div><?php echo "Bidang : $bidang"; ?></div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main class="container mt-5">
            <div class="p-4">
                    <div class="card shadow ">
                        <div class="card-body">
                            <?php
                            if (!empty($notificationMessage)) {
                                echo '<div class="alert alert-success">' . htmlspecialchars($notificationMessage) . '</div>';
                            }
                            ?>
                            <h1>Data bidang</h1>
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addBidangModal">Tambah Data Bidang</button>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover  table-striped table-sm">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th style="width: 200px">Nama bidang</th>
                                            <th style="width: 120px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $host = "localhost";
                                        $username = "root";
                                        $password = "";
                                        $dbname = "bpkad";

                                        $conn = mysqli_connect($host, $username, $password, $dbname);

                                        if (!$conn) {
                                            die("Koneksi Database Gagal : " . mysqli_connect_error());
                                        }

                                        $searchTerm = isset($_GET['search_nama_bidang']) ? $_GET['search_nama_bidang'] : "";

                                        // Menghitung total data
                                        $total_data = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bidang WHERE nama_bidang LIKE '%$searchTerm%'"));

                                        // Batasan data per halaman
                                        $data_per_page = 5;

                                        // Menghitung jumlah halaman
                                        $total_pages = ceil($total_data / $data_per_page);

                                        // Mendapatkan halaman saat ini
                                        if (isset($_GET['page'])) {
                                            $current_page = $_GET['page'];
                                        } else {
                                            $current_page = 1;
                                        }

                                        // Menentukan starting limit
                                        $starting_limit = ($current_page - 1) * $data_per_page;
                                        $sql = "SELECT * FROM bidang";

                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                            $searchTerm = $_POST["cari_bidang"];
                                            $sql = "SELECT * FROM bidang WHERE nama_bidang LIKE '%$searchTerm%' LIMIT $starting_limit, $data_per_page";
                                        }
                                        $result = mysqli_query($conn, $sql);

                                        if (mysqli_num_rows($result) > 0) {
                                            $no = $starting_limit + 1; // Inisialisasi nomor urut
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . $no . "</td>"; // Menampilkan nomor urut
                                                echo "<td>" . $row["nama_bidang"] . "</td>";
                                                echo '<td>
            <a class="btn btn-danger" href="../../data/hapus_data/hapus_data_bidang.php?no=' . $row["no"] . '">Hapus</a>
            <button class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editModal" data-no="' . $row["no"] . '">Edit</button>
        </td>';
                                                echo "</tr>";
                                                $no++; // Increment nomor urut
                                            }
                                        } else {
                                            echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
                                        }

                                        mysqli_close($conn);
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination justify-content-left mt-3">
                                <ul class="pagination">
                                    <?php
                                    // Tombol Prev (Sebelumnya)
                                    $prevPage = ($current_page > 1) ? $current_page - 1 : 1;
                                    echo "<li class='page-item'><a class='page-link' href='?page=$prevPage'>Prev</a></li>";

                                    // Tampilkan nomor halaman saat ini
                                    echo "<li class='page-item active'><a class='page-link'>$current_page</a></li>";

                                    // Tombol Next (Selanjutnya)
                                    $nextPage = ($current_page < $total_pages) ? $current_page + 1 : $total_pages;
                                    echo "<li class='page-item'><a class='page-link' href='?page=$nextPage'>Next</a></li>";
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </main>


            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Arsip BPKAD 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <!-- Skrip JavaScript untuk menampilkan popup edit -->
    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function() {
                var no = $(this).data('no');
                $('#edit_no').val(no); // Isi input hidden dengan nomor (no)
                $('#editModal').modal('show');

                var nama_bidang = $(this).closest('tr').find('td:eq(1)').text(); // Ambil nama bidang dari baris tabel

                $('#nama_bidang_edit').val(nama_bidang);
            });
        });
        $(".btn-danger").on("click", function(event) {
            if (!confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                event.preventDefault(); // Mencegah aksi default tombol jika konfirmasi ditolak
            }
        });
    </script>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Bidang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="../../data/edit_data/update_data_bidang.php"> <!-- Buat file baru: update_data_jabatan.php -->
                        <div class="form-group">
                            <label for="nama_bidang_edit">Nama Bidang:</label>
                            <input type="text" class="form-control" id="nama_bidang_edit" name="nama_bidang_edit" required>
                        </div>
                        <input type="hidden" id="edit_no" name="edit_no">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Popup Form -->
    <div class="modal fade" id="addBidangModal" tabindex="-1" role="dialog" aria-labelledby="addBidangModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBidangModalLabel">Form Input Bidang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="../../data/simpan_data/simpan_data_bidang.php">
                        <div class="form-group">
                            <label for="nama_bidang">Nama Bidang:</label>
                            <input type="text" class="form-control" name="nama_bidang" id="nama_bidang" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>