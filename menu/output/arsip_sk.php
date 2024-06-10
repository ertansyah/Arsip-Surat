<?php
session_start();

$jabatan = $_SESSION['jabatan'];
$bidang = $_SESSION['bidang'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Surat Keluar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="../../User/index.php">
            <img src="../../assets/img/bpkad1.png" alt="BPKAD Logo" style="max-width: 150px; height: auto;" />
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" action="" method="get">
            <div class="input-group">
                <input class="form-control" type="text" name="search_no_surat" placeholder="Cari No Surat" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
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
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="../../User/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="arsip_sm.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-inbox"></i></div>
                            Surat Masuk
                        </a>
                        <a class="nav-link" href="arsip_sk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                            Surat Keluar
                        </a>
                        <a class="nav-link" href="pending.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Status Disposisi
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
            <?php
            include '../../config.php';
            function getLampiranOptions()
            {
                $lampiran = array();
                $query = "SELECT * FROM tb_lampiran";
                $result = mysqli_query(koneksiDB(), $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $lampiran[] = $row['lampiran'];
                }

                return $lampiran;
            }

            // Fungsi untuk mengambil data dari tabel tb_sifat
            function getSifatOptions()
            {
                $sifat = array();
                $query = "SELECT * FROM tb_sifat";
                $result = mysqli_query(koneksiDB(), $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $sifat[] = $row['sifat'];
                }

                return $sifat;
            }

            function filterDataByDateAndPage($tanggal_dari, $tanggal_sampai, $no_surat, $page)
            {
                $offset = ($page - 1) * 10;
                $whereClause = "";

                if (!empty($tanggal_dari) && !empty($tanggal_sampai)) {
                    $whereClause .= " AND tanggal_keluar BETWEEN '$tanggal_dari' AND '$tanggal_sampai'";
                }

                if (!empty($no_surat)) {
                    $whereClause .= " AND no_surat LIKE '%$no_surat%'";
                }

                $query = "SELECT * FROM tb_tsk WHERE 1 $whereClause ORDER BY no_surat ASC LIMIT $offset, 10";
                $countQuery = "SELECT COUNT(*) as total FROM tb_tsk WHERE 1 $whereClause";

                $result = mysqli_query(koneksiDB(), $query);
                $countResult = mysqli_query(koneksiDB(), $countQuery);
                $totalCount = mysqli_fetch_assoc($countResult)['total'];

                return array('data' => $result, 'totalCount' => $totalCount);
            }

            $page = $_GET['page'] ?? 1;
            $tanggal_dari = $_GET['tanggal_dari'] ?? '';
            $tanggal_sampai = $_GET['tanggal_sampai'] ?? '';
            $no_surat = $_GET['search_no_surat'] ?? '';

            $resultData = filterDataByDateAndPage($tanggal_dari, $tanggal_sampai, $no_surat, $page);
            $result = $resultData['data'];
            $countData = $resultData['totalCount'];
            ?>

            <main class="container-fluid">
                <div class="p-4">
                    <div class="card shadow ">
                        <div class="card-body">
                            <div class="p-3">
                                <?php
                                // Tampilkan pesan notifikasi jika ada (untuk upload)
                                if (isset($_SESSION['upload_message'])) {
                                    $uploadMessage = $_SESSION['upload_message'];
                                    unset($_SESSION['upload_message']); // Hapus pesan notifikasi setelah ditampilkan

                                    // Tentukan kelas alert Bootstrap berdasarkan tipe notifikasi
                                    $uploadClass = (strpos($uploadMessage, 'Berhasil') !== false) ? 'alert-success' : 'alert-danger';

                                    // Tampilkan notifikasi upload dengan komponen alert Bootstrap
                                    echo "<div class='alert $uploadClass'>$uploadMessage</div>";
                                }

                                // Tampilkan pesan notifikasi jika ada (untuk update)
                                if (isset($_SESSION['update_message'])) {
                                    $updateMessage = $_SESSION['update_message'];
                                    unset($_SESSION['update_message']); // Hapus pesan notifikasi setelah ditampilkan

                                    // Tentukan kelas alert Bootstrap berdasarkan tipe notifikasi
                                    $updateClass = (strpos($updateMessage, 'Data berhasil diperbarui.') !== false) ? 'alert-success' : 'alert-danger';

                                    // Tampilkan notifikasi update dengan komponen alert Bootstrap
                                    echo "<div class='alert $updateClass'>$updateMessage</div>";
                                }

                                // Tampilkan pesan notifikasi jika ada (untuk delete)
                                if (isset($_SESSION['delete_message'])) {
                                    $deleteMessage = $_SESSION['delete_message'];
                                    unset($_SESSION['delete_message']); // Hapus pesan notifikasi setelah ditampilkan

                                    // Tentukan kelas alert Bootstrap berdasarkan tipe notifikasi
                                    $deleteClass = (strpos($deleteMessage, 'Data  berhasil dihapus.') !== false) ? 'alert-success' : 'alert-danger';

                                    // Tampilkan notifikasi delete dengan komponen alert Bootstrap
                                    echo "<div class='alert $deleteClass'>$deleteMessage</div>";
                                }
                                ?>
                                <h2 class="text-center">Arsip Data Surat Keluar</h2>
                                <a href="../input/tsk.php" class="btn btn-primary">Tambah Data</a>
                                <form action="" method="get" class="mt-3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="tanggal_dari">Dari Tanggal:</label>
                                            <input type="date" class="form-control" name="tanggal_dari" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="tanggal_sampai">Sampai Tanggal:</label>
                                            <input type="date" class="form-control" name="tanggal_sampai" required>
                                        </div>
                                        <div class="col-md-2 mt-2">
                                            <button type="submit" class="btn btn-primary mt-4">Filter Tanggal</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover  table-striped table-sm">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="width: 30px">No</th>
                                            <th style="width: 100px">Nomor Surat</th>
                                            <th style="width: 200px">Nama Surat</th>
                                            <th style="width: 200px">Instansi</th>
                                            <th style="width: 200px">No Agenda</th>
                                            <th style="width: 150px">Tanggal Surat</th>
                                            <th style="width: 150px">Tanggal Keluar</th>
                                            <th style="width: 200px">Prihal</th>
                                            <th style="width: 200px">Lampiran</th>
                                            <th style="width: 200px">Sifat</th>
                                            <th style="width: 50px">Type</th>
                                            <th style="width: 100px">Ukuran</th>
                                            <th style="width: 200px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($countData < 1) {
                                        ?>
                                            <tr>
                                                <td colspan="10" class="text-center font-weight-bold" style="color: red;">TIDAK ADA DATA</td>
                                            </tr>
                                            <?php
                                        } else {
                                            $nomor_urut = ($page - 1) * 10;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $nomor_urut++;
                                            ?>
                                                <tr>
                                                    <td><?php echo $nomor_urut; ?></td>
                                                    <td><?php echo $row['no_surat']; ?></td>
                                                    <td><?php echo $row['nama_surat']; ?></td>
                                                    <td><?php echo $row['instansi']; ?></td>
                                                    <td><?php echo $row['no_agenda']; ?></td>
                                                    <td><?php echo $row['tanggal_surat']; ?></td>
                                                    <td><?php echo $row['tanggal_keluar']; ?></td>
                                                    <td><?php echo $row['prihal']; ?></td>
                                                    <td><?php echo $row['lampiran']; ?></td>
                                                    <td><?php echo $row['sifat']; ?></td>
                                                    <td><?php echo strtoupper(pathinfo($row['berkas'], PATHINFO_EXTENSION)); ?></td>
                                                    <td><?php echo number_format($row['size'] / (1024 * 1024), 2); ?> MB</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center flex-column">
                                                            <div class="btn-group mb-2" role="group">
                                                                <?php if (in_array($row['ekstensi'], ['pdf', 'jpg', 'jpeg', 'png'])) : ?>
                                                                    <a href="<?php echo $row['berkas']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="View" target="_blank">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                <?php else : ?>
                                                                    <span class="text-muted">Invalid File Type</span>
                                                                <?php endif; ?>
                                                                <?php if (in_array($row['ekstensi'], ['pdf', 'jpg', 'jpeg', 'png'])) : ?>
                                                                    <a href="<?php echo $row['berkas']; ?>" download class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Download">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#editModal<?php echo $row['id_tsk']; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <div class="modal fade" id="editModal<?php echo $row['id_tsk']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <!-- Form untuk mengedit data -->
                                                                                <form action="../../data/edit_data/update_data_kel.php" method="post">
                                                                                    <input type="hidden" name="id_tsk" value="<?php echo $row['id_tsk']; ?>">
                                                                                    <div class="form-row">
                                                                                        <!-- Bagian Kiri -->
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="no_surat"><i class="fa fa-envelope"></i> Nomor Surat:</label>
                                                                                                <input type="text" class="form-control" id="no_surat" name="no_surat" value="<?php echo $row['no_surat']; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- Bagian Tengah -->
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="nama_surat"><i class="fa fa-file"></i> Nama Surat:</label>
                                                                                                <input type="text" class="form-control" id="nama_surat" name="nama_surat" value="<?php echo $row['nama_surat']; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- Bagian Kanan -->
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="instansi"><i class="fa fa-building"></i> Instansi:</label>
                                                                                                <input type="text" class="form-control" id="instansi" name="instansi" value="<?php echo $row['instansi']; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Form-group lainnya -->
                                                                                    <div class="form-row">
                                                                                        <!-- Bagian Kiri -->
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="no_agenda"><i class="fa fa-list-alt"></i> No Agenda:</label>
                                                                                                <input type="text" class="form-control" id="no_agenda" name="no_agenda" value="<?php echo $row['no_agenda']; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- Bagian Tengah -->
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="tanggal_surat"><i class="fa fa-calendar"></i> Tanggal Surat:</label>
                                                                                                <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" value="<?php echo $row['tanggal_surat']; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- Bagian Kanan -->
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="tanggal_keluar"><i class="fa fa-calendar-check"></i> Tanggal Keluar:</label>
                                                                                                <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" value="<?php echo $row['tanggal_keluar']; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-row">
                                                                                        <!-- Bagian Kiri -->
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="prihal"><i class="fa fa-file-text"></i> Prihal:</label>
                                                                                                <input type="text" class="form-control" id="prihal" name="prihal" value="<?php echo $row['prihal']; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- Bagian Tengah -->
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="lampiran"><i class="fa fa-paperclip"></i> Lampiran:</label>
                                                                                                <select class="form-control" id="lampiran" name="lampiran">
                                                                                                    <?php
                                                                                                    $lampiran = getLampiranOptions();
                                                                                                    foreach ($lampiran as $lampiran) {
                                                                                                        // Cek apakah opsi saat ini sama dengan data yang sudah dipilih sebelumnya
                                                                                                        $selected = ($lampiran === $row['lampiran']) ? 'selected' : '';

                                                                                                        echo "<option value='$lampiran' $selected>$lampiran</option>";
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- Bagian Kanan -->
                                                                                        <div class="col-md-4">
                                                                                            <label for="sifat"><i class="fa fa-flag"></i> Sifat:</label>
                                                                                            <select class="form-control" id="sifat" name="sifat">
                                                                                                <?php
                                                                                                $sifat = getSifatOptions();
                                                                                                foreach ($sifat as $sifat) {
                                                                                                    // Cek apakah opsi saat ini sama dengan data yang sudah dipilih sebelumnya
                                                                                                    $selected = ($sifat === $row['sifat']) ? 'selected' : '';

                                                                                                    echo "<option value='$sifat' $selected>$sifat</option>";
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Tambahkan input untuk data lainnya yang ingin diubah -->
                                                                                    <div class="text-right">
                                                                                        <button type="submit" class="btn btn-primary">Update Data</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a href="../../data/hapus_data/hapus_sk.php?id_tsk=<?php echo $row['id_tsk']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Hapus">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Bagian HTML untuk tampilan navigasi halaman -->
                            <div class="pagination justify-content-left mt-3">
                                <ul class="pagination">
                                    <?php
                                    $totalPages = ceil($countData / 10);

                                    // Tombol Prev (Sebelumnya)
                                    $prevPage = ($page > 1) ? $page - 1 : 1;
                                    echo "<li class='page-item'><a class='page-link' href='?page=$prevPage&tanggal_dari=$tanggal_dari&tanggal_sampai=$tanggal_sampai'>Prev</a></li>";

                                    // Tampilkan nomor halaman saat ini
                                    echo "<li class='page-item active'><a class='page-link'>$page</a></li>";

                                    // Tombol Next (Selanjutnya)
                                    $nextPage = ($page < $totalPages) ? $page + 1 : $totalPages;
                                    echo "<li class='page-item'><a class='page-link' href='?page=$nextPage&tanggal_dari=$tanggal_dari&tanggal_sampai=$tanggal_sampai'>Next</a></li>";
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const updateForm = document.querySelector("form[action='../../data/edit_data/update_data_kel.php']");

            updateForm.addEventListener("submit", function(e) {
                e.preventDefault(); // Mencegah pengiriman formulir secara otomatis

                // Tampilkan notifikasi konfirmasi
                const confirmation = confirm("Data baru akan disimpan. Apakah Anda yakin?");

                if (confirmation) {
                    // Jika "Iya" dipilih, lanjutkan dengan pengiriman formulir
                    this.submit(); // Kirim formulir
                } else {
                    // Jika "Tidak" dipilih, batal pengiriman formulir
                    // Anda dapat menambahkan tindakan tambahan di sini jika diperlukan
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.getScript("https://code.jquery.com/ui/1.12.1/jquery-ui.js", function() {
                $("#tanggal_dari").datepicker({
                    dateFormat: 'yy-mm-dd', // Ubah format tanggal menjadi 'yyyy-mm-dd'
                    changeMonth: true,
                    changeYear: true,
                    showOn: 'focus'
                });
                $("#tanggal_sampai").datepicker({
                    dateFormat: 'yy-mm-dd', // Ubah format tanggal menjadi 'yyyy-mm-dd'
                    changeMonth: true,
                    changeYear: true,
                    showOn: 'focus'
                });
            });
        });
    </script>
</body>

</html>