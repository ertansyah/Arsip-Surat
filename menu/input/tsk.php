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
    <title>Surat Keluar - BPKAD</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        /* Adjust z-index for the datepicker */
        .datepicker {
            z-index: 999 !important;
            /* Change this value as needed */
        }

        /* Ensure calendar dropdown is not cut off */
        .datepicker.dropdown-menu {
            top: auto;
            transform: translate3d(0, 100%, 0);
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">
            <img src="../../assets/img/bpkad1.png" alt="BPKAD Logo" style="max-width: 150px; height: auto;" />
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
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
                        <a class="nav-link" href="../output/arsip_sm.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-inbox"></i></div>
                            Surat Masuk
                        </a>
                        <a class="nav-link" href="../output/arsip_sk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                            Surat Keluar
                        </a>
                        <a class="nav-link" href="../menu/output/pending.php">
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
            <main class="container" style="width: 800px; margin: auto; padding: 10px;">
            <div class="p-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h2 class="text-center">Form Upload Surat Keluar</h2>
                        </div>
                        <div class="card-body">
                            <form action="../../data/simpan_data/simpan_tsk.php" method="post" enctype="multipart/form-data" id="upload-form" class="needs-validation">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="no_surat" class="form-label">Nomor Surat :</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-book"></i></span>
                                                <input type="text" class="form-control" id="no_surat" name="no_surat" placeholder="Masukkan Nomor Surat" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="instansi" class="form-label">Instansi :</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                <input type="text" class="form-control" id="instansi" name="instansi" placeholder="Masukkan Nama Instansi" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="nama_surat" class="form-label">Judul Surat :</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                                <input type="text" class="form-control" id="nama_surat" name="nama_surat" placeholder="Masukkan Judul Surat" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="no_agenda" class="form-label">Nomor Agenda :</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                                <input type="text" class="form-control" id="no_agenda" name="no_agenda" placeholder="Masukkan Nomor Agenda" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="tanggal_keluar" class="form-label">Tanggal Keluar:</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                <input type="text" class="form-control datepicker" id="tanggal_keluar" name="tanggal_keluar" placeholder="yyyy-mm-dd" readonly data-provide="datepicker" required>
                                                <button type="button" class="btn btn-primary" id="btnToday_tanggal_keluar">Hari Ini</button>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_surat" class="form-label">Tanggal Surat:</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                <input type="text" class="form-control datepicker" id="tanggal_surat" name="tanggal_surat" placeholder="yyyy-mm-dd" readonly data-provide="datepicker" required>
                                                <button type="button" class="btn btn-primary" id="btnToday_tanggal_surat">Hari Ini</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="prihal" class="form-label">Prihal :</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-certificate"></i></span>
                                                <input type="text" class="form-control" id="prihal" name="prihal" placeholder="Masukkan Prihal" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="lampiran" class="form-label">Lampiran :</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-paperclip"></i></span>
                                                <select class="form-select" id="lampiran" name="lampiran" >
                                                    <option value="" required disabled selected>Pilih Lampiran</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="sifat" class="form-label">Sifat :</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                                <select class="form-select" id="sifat" name="sifat">
                                                    <option value=""  disabled selected>Pilih Sifat</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="berkas" class="form-label">Upload File :</label>
                                            <input class="form-control" type="file" id="berkas" name="berkas" accept=".pdf, .jpg, .jpeg, .png" required>
                                            <span class="form-text text-muted">Hanya mendukung file PDF, JPEG, dan PNG.</span>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-primary" id="upload-button" disabled>Upload File</button>
                        </div>
                        </form>
                    </div>
                </div>


                <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered table-hover  table-striped table-sm">
                                    <tr>
                                        <td>Nomor Surat</td>
                                        <td><span id="modal-no-surat"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Instansi</td>
                                        <td><span id="modal-instansi"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Surat</td>
                                        <td><span id="modal-nama-surat"></span></td>
                                    </tr>
                                    <tr>
                                        <td>No Agenda</td>
                                        <td><span id="modal-no-agenda"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal keluar</td>
                                        <td><span id="modal-tanggal-keluar"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Surat</td>
                                        <td><span id="modal-tanggal-surat"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Prihal</td>
                                        <td><span id="modal-prihal"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Lampiran</td>
                                        <td><span id="modal-lampiran"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Berkas</td>
                                        <td><span id="modal-berkas-name"></span></td>
                                    </tr>
                                </table>

                                <iframe id="modal-berkas-iframe" width="100%" height="500"></iframe>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" id="confirm-upload">Simpan</button>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../../js/get_lampiran.js"></script>
    <script src="../../js/get_sifat.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const uploadButton = document.getElementById("upload-button");
            const uploadForm = document.getElementById("upload-form");
            const noSurat = document.getElementById("no_surat");
            const instansi = document.getElementById("instansi");
            const namaSurat = document.getElementById("nama_surat");
            const noAgenda = document.getElementById("no_agenda");
            const tanggalKeluar = document.getElementById("tanggal_keluar");
            const tanggalSurat = document.getElementById("tanggal_surat");
            const prihal = document.getElementById("prihal");
            const lampiran = document.getElementById("lampiran");
            const berkas = document.getElementById("berkas");
            const berkasIframe = document.getElementById("modal-berkas-iframe");
            const confirmationModal = new bootstrap.Modal(document.getElementById("confirmationModal"));

            function showConfirmationModal() {
                document.getElementById("modal-no-surat").textContent = noSurat.value;
                document.getElementById("modal-instansi").textContent = instansi.value;
                document.getElementById("modal-nama-surat").textContent = namaSurat.value;
                document.getElementById("modal-no-agenda").textContent = noAgenda.value;
                document.getElementById("modal-tanggal-keluar").textContent = tanggalKeluar.value;
                document.getElementById("modal-tanggal-surat").textContent = tanggalSurat.value;
                document.getElementById("modal-prihal").textContent = prihal.value;
                document.getElementById("modal-lampiran").textContent = lampiran.value;
                document.getElementById("modal-berkas-name").textContent = berkas.files[0].name;

                // Menetapkan src iframe untuk menampilkan berkas
                berkasIframe.src = URL.createObjectURL(berkas.files[0]);

                confirmationModal.show();
            }

            uploadButton.addEventListener("click", function() {
                showConfirmationModal();
            });

            document.getElementById("confirm-upload").addEventListener("click", function() {
                uploadForm.submit();
            });

            noSurat.addEventListener("input", checkFormValidity);
            instansi.addEventListener("input", checkFormValidity);
            namaSurat.addEventListener("input", checkFormValidity);
            noAgenda.addEventListener("input", checkFormValidity);
            tanggalKeluar.addEventListener("input", checkFormValidity);
            tanggalSurat.addEventListener("input", checkFormValidity);
            prihal.addEventListener("input", checkFormValidity);
            lampiran.addEventListener("input", checkFormValidity);
            berkas.addEventListener("input", checkFormValidity);

            function checkFormValidity() {
                if (uploadForm.checkValidity()) {
                    uploadButton.disabled = false;
                } else {
                    uploadButton.disabled = true;
                }
            }
        });
    </script>
    <script>
        function getTodayDate() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Tambahkan event listener untuk tombol "Hari Ini"
        document.getElementById('btnToday_tanggal_surat').addEventListener('click', function() {
            document.getElementById('tanggal_surat').value = getTodayDate();
        });

        document.getElementById('btnToday_tanggal_keluar').addEventListener('click', function() {
            document.getElementById('tanggal_keluar').value = getTodayDate();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd', // Mengatur format tanggal menjadi 'yyyy-mm-dd'
                autoclose: true
            });
        });
    </script>
</body>

</html>