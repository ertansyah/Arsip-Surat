<?php
session_start();

// Check if the user is already logged in as admin or other roles
if (isset($_SESSION['jabatan'])) {
    switch ($_SESSION['jabatan']) {
        case 'Admin':
            header("location: admin/index.php");
            exit();
            break;
        case 'Sekretaris':
            header("location: User/index_skre.php");
            exit();
            break;
        case 'Kepala BPKAD':
            header("location: User/index_kepala.php");
            exit();
            break;
        case 'Kasubag/Kasi':
        case 'Kabid':
            header("location: User/index.php");
            exit();
            break;
        default:
            // Handle other roles if needed
            break;
    }
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "bpkad";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

$errorMessage = "";
$redirectTo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nip = $_POST['nip'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM user WHERE nip = '$nip'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $userRow = mysqli_fetch_assoc($result);

        if (password_verify($pass, $userRow['pass'])) {
            // Login berhasil
            $_SESSION['nip'] = $nip;
            $_SESSION['jabatan'] = $userRow['jabatan']; // Menyimpan peran (jabatan)
            $_SESSION['bidang'] = $userRow['bidang'];   // Menyimpan bidang
            $_SESSION['idUser'] = $userRow['idUser'];   // Menyimpan idUser

            // Menentukan halaman yang akan diarahkan
            if ($userRow['jabatan'] == 'Admin' && $userRow['bidang'] == 'Admin') {
                $redirectTo = "admin/index.php";
            } elseif ($userRow['jabatan'] == 'Sekretaris' && $userRow['bidang'] == 'Sekretariat') {
                $redirectTo = "User/index_skre.php";
            } elseif ($userRow['jabatan'] == 'Kepala BPKAD' && $userRow['bidang'] == 'Kepala BPKAD') {
                $redirectTo = "User/index_kepala.php";
            } elseif ($userRow['jabatan'] == 'Kasubag/Kasi' || $userRow['jabatan'] == 'Kabid' && $userRow['bidang'] == 'Umum') {
                $redirectTo = "User/index.php";
            } else {
                $errorMessage = "Role atau bidang tidak didukung.";
            }

            // Redirect ke halaman yang sesuai
            header("Location: $redirectTo");
            exit(); // Penting untuk menghentikan eksekusi script setelah redirect
        } else {
            $errorMessage = "<span style='color: white;'>NIP atau password salah.</span>";
        }
    } else {
        $errorMessage = "<span style='color: white;'>NIP atau password salah.</span>";
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">

    <style>
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container-left">
            <lottie-player class="logo-png" src="https://lottie.host/64519415-f956-4af0-809f-9ce52d6f1513/x1DocLmtiT.json" background="" speed="1" style="width: 300px; height: 300px" direction="1" mode="normal" loop autoplay></lottie-player>
        </div>
        <div class="container-right">
            <form method="POST" action="login.php" id="loginForm">
                <div class="container-right">
                    <img src="assets/img/bpkad1.png" alt="Logo BPKAD" class="logo-img">
                </div>
                <div class="input">
                    <label for="nip" class="form-label">NIP:</label>
                    <input type="text" class="form-control" id="nip" name="nip" required>
                </div>
                <div class="input">
                    <label for="pass" class="form-label">Kata Sandi:</label>
                    <input type="password" class="form-control" id="pass" name="pass" required>
                </div>
                <?php echo $errorMessage; ?>
                <button type="submit" id="loginButton">Masuk</button>
            </form>
        </div>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <lottie-player src="https://lottie.host/4147a7c6-aba0-49aa-9835-f6784e98cda0/KnAwdSzhf8.json" background="" speed="1" style="width: 600px; height: 600px;" direction="1" mode="normal" loop autoplay></lottie-player>
        <p>Mohon tunggu...</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var loginForm = document.getElementById("loginForm");
            var loadingOverlay = document.getElementById("loadingOverlay");

            loginForm.addEventListener("submit", function(event) {
                event.preventDefault();
                showLoading();
            });

            function showLoading() {
                loadingOverlay.style.display = "flex";

                setTimeout(function() {
                    // Lanjutkan dengan proses login (form submit)
                    loginForm.submit();
                }, 2000);
            }
        });
    </script>
</body>

</html>
