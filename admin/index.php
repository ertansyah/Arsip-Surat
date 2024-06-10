<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "bpkad";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi Database Gagal : " . mysqli_connect_error());
}
session_start();
$jabatan = $_SESSION['jabatan'] ?? 'Tidak Diketahui';
$bidang = $_SESSION['bidang'] ?? 'Tidak Diketahui';

$notificationMessage = isset($_GET['notification']) ? $_GET['notification'] : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        // Store the current URL
        var currentUrl = window.location.href;

        // Disable back button on the browser
        history.pushState(null, null, currentUrl);
        window.onpopstate = function() {
            history.go(1);
        };
    </script>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Admin BPKAD</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/slideshow.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="../css/styles.css" rel="stylesheet">
    <script src="../js/get_total_users.js"></script>
    <script src="../js/get_total_jabatan.js"></script>
    <script src="../js/get_total_bidang.js"></script>
    <script src="../js/get_total_lampiran.js"></script>
    <script src="../js/get_total_sifat.js"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">
            <img src="../assets/img/bpkad1.png" alt="BPKAD Logo" style="max-width: 150px; height: auto;" />
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        </div>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
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
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="../menu/output/user.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>
                            Data user
                        </a>
                        <a class="nav-link" href="../menu/output/jabatan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-address-card "></i></div>
                            Data Jabatan
                        </a>
                        <a class="nav-link" href="../menu/output/bidang.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>
                            Data Bidang
                        </a>
                        <a class="nav-link" href="../menu/output/lampiran.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-paperclip"></i></div>
                            Data Lampiran
                        </a>
                        <a class="nav-link" href="../menu/output/sifat.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-certificate"></i></div>
                            Data Sifat
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

            <main>
                <div class="p-4">
                    <div class="card shadow ">
                        <div class="card-body">
                            <div class="container-fluid px-4">
                                <h1 class="mt-4">Dashboard</h1>
                                <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                                <div class="row">
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card bg-primary text-white mb-4">
                                            <div class="card-body d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-0">Data User</p>
                                                    <p class="mb-0" id="jumlahuser">Loading...</p>

                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user fa-2x mr-3"></i>
                                                    <div class="small text-white"><i class=""></i></div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex align-items-center justify-content-between">
                                                <a class="small text-white stretched-link" href="../menu/output/user.php">Lihat Detail</a>
                                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card bg-warning text-white mb-4">
                                            <div class="card-body d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-0">Data Jabatan </p>
                                                    <p class="mb-0" id="jumlahjabatan">Loading...</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-address-card fa-2x mr-3"></i>
                                                    <div class="small text-white"><i class=""></i></div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex align-items-center justify-content-between">
                                                <a class="small text-white stretched-link" href="../menu/output/jabatan.php">Lihat Detail</a>
                                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card bg-success text-white mb-4">
                                            <div class="card-body d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-0">Data Bidang</p>
                                                    <p class="mb-0" id="jumlahbidang">Loading...</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-briefcase fa-2x mr-3"></i>
                                                    <div class="small text-white"><i class=""></i></div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex align-items-center justify-content-between">
                                                <a class="small text-white stretched-link" href="../menu/output/bidang.php">Lihat Detail</a>
                                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card bg-info text-white mb-4">
                                            <div class="card-body d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-0">Data Lampiran</p>
                                                    <p class="mb-0" id="jumlahlampiran">Loading...</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-paperclip fa-2x mr-3"></i>
                                                    <div class="small text-white"><i class=""></i></div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex align-items-center justify-content-between">
                                                <a class="small text-white stretched-link" href="../menu/output/lampiran.php">Lihat Detail</a>
                                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card bg-danger text-white mb-4">
                                            <div class="card-body d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-0">Data Sifat</p>
                                                    <p class="mb-0" id="jumlahsifat">Loading...</p>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-certificate fa-2x mr-3"></i>
                                                    <div class="small text-white"><i class=""></i></div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex align-items-center justify-content-between">
                                                <a class="small text-white stretched-link" href="../menu/output/sifat.php">Lihat Detail</a>
                                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="slideShow" class="slide-show">
                    <div id="slideButton" class="slide-button" onclick="toggleSlide()">
                        <span class="slide-text"><i class="fas fa-question-circle"></i> Bantuan</span>
                    </div>
                    <div id="slideContent" class="slide-content">
                        <div class="card">
                            <div class="card-body">
                                <h5><i class="fas fa-file-pdf"></i> Buku Petunjuk Lengkap </h5>
                                <a href="../file/Admin BPKAD Apps.pdf" target="_blank"><i class="fas fa-file-pdf"></i>Lihat Buku Petunjuk </a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5><i class="fas fa-play-circle"></i> Video Petunjuk</h5>
                                <iframe width="800" height="450" src="https://www.youtube.com/embed/7MYyVzf6KuE" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script>
        getTotalUsers();
        getTotalJabatan();
        getTotalBidang();
        getTotalLampiran()
        getTotalSifat()
    </script>
    <script>
        var slideContent = document.getElementById("slideContent");
        var slideButton = document.getElementById("slideButton");

        function toggleSlide() {
            if (slideContent.style.display === "none" || slideContent.style.display === "") {
                slideContent.style.display = "block";
                slideContent.style.animation = "none";
                setTimeout(function() {
                    slideContent.style.animation = "slide 0.5s ease-out forwards";
                }, 100);

                // Menambah event listener untuk menutup konten saat di luar konten diklik
                window.addEventListener("click", closeOutsideContent);
            }
        }

        function closeOutsideContent(event) {
            if (!slideButton.contains(event.target) && !slideContent.contains(event.target)) {
                slideContent.style.animation = "none";
                setTimeout(function() {
                    slideContent.style.animation = "slide-reverse 0.5s ease-out forwards";
                    slideContent.style.display = "none";
                }, 100);
                window.removeEventListener("click", closeOutsideContent);
            }
        }
    </script>
</body>

</html>