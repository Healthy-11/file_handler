<?php
session_start();
if (isset($_POST['download']) && isset($_POST['dlfile'])) {
    $file_name = $_POST['dlfile'];
    try {
        $ftp = ftp_connect("focus.immo", 21);
        ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
        ftp_pasv($ftp, true);
        $local_file = "downloaded.pdf";
        if (ftp_get($ftp, $local_file, $_SESSION["code"] . "/signed/" . $file_name, FTP_BINARY)) {
            $file_new_name = $file_name;
            header('Content-Type: application/pdf');
            header("Content-Disposition: attachment; filename=\"" . $file_new_name . '"');
            readfile($local_file);
        }
        ftp_close($ftp);
    } catch (Exception $e) {
        //echo "Connexion échouée: " . $e->getMessage();
    }
}
header("Location: ../signed");