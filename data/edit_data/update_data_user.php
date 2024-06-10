<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/PHPMailer.php'; 
require '../../PHPMailer/src/SMTP.php'; 
require '../../PHPMailer/src/Exception.php'; 

$host = "localhost";
$username = "root";
$password = "";
$dbname = "bpkad";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi Database Gagal : " . mysqli_connect_error());
}

$notificationMessage = "";
$notificationType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nip = $_POST['editnip'];
    $nama = $_POST['editNama'];
    $newPassword = $_POST['editpass'];
    $email = $_POST['editemail']; 
    $noTlp = $_POST['editNoTlp'];
    $jabatan = $_POST['editJabatan'];
    $bidang = $_POST['editBidang'];
    $originalPassword = $_POST['original_pass'];

    // Check if a new password is provided
    if (!empty($newPassword)) {
        // Use the provided password as is
        $hashedNewPassword = $newPassword;
        $sql = "UPDATE user SET nama='$nama', pass='$hashedNewPassword', no_tlp='$noTlp', email='$email', jabatan='$jabatan', bidang='$bidang' WHERE nip='$nip'";
    } else {
        // If no new password is provided, keep the original password
        $sql = "UPDATE user SET nama='$nama', no_tlp='$noTlp', email='$email', jabatan='$jabatan', bidang='$bidang' WHERE nip='$nip'";
    }

    if (mysqli_query($conn, $sql)) {
        $notificationMessage = "Data berhasil diperbarui.";
        $notificationType = "success";

        // Kirim email menggunakan PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'arsipbpkad2023@gmail.com'; 
            $mail->Password = 'uznotlfcmbbswffn'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587; 

            $mail->setFrom('no-reply@arsip.bpkad.com', 'Admin Arsip BPKAD');
            $mail->addAddress($email, $nama);
            $mail->Subject = 'Pembaruan Data Akun';

            if (!empty($newPassword)) {
                $mail->Body = "Data akun Anda telah diperbarui di Aplikasi Arsip BPKAD.\n\n Jabatan : $jabatan\n Bidang : $bidang\n NIP: $nip\n Password Baru: $newPassword \n Anda dapat mencoba login ke Arsip BPKAD dengan menggunakan password baru ini.";
            } else {
                $mail->Body = "Data akun Anda telah diperbarui di Aplikasi Arsip BPKAD.\n\n Jabatan : $jabatan\n Bidang : $bidang\n NIP: $nip\n Password tetap sama.";
            }

            $mail->send();

            $notificationMessage .= " Email pemberitahuan berhasil dikirim.";
        } catch (Exception $e) {
            $notificationMessage .= " Terjadi kesalahan saat mengirim email: {$mail->ErrorInfo}";
        }
    } else {
        $errorMessage = "Error: " . mysqli_error($conn);
        $notificationMessage = "Terjadi kesalahan saat memperbarui data: $errorMessage";
        $notificationType = "danger";
    }
}

mysqli_close($conn);

if (!empty($notificationMessage)) {
    header("Location: ../../menu/output/user.php?notification=" . urlencode($notificationMessage) . "&notificationType=" . $notificationType);
} else {
    header("Location: ../../menu/output/user.php");
}
exit();
?>
