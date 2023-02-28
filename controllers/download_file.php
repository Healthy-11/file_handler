<?php
session_start();

if (isset($_POST['download'])) {
    if (isset($_POST['dlfileSigned'])) {
        $file_name = $_POST['dlfileSigned'];
        $remote = "/signed/";
    }
    if (isset($_POST['dlfileToSign'])) {
        $file_name = $_POST['dlfileToSign'];
        $remote = "/toSign/";
    }
    if (isset($file_name) && isset($remote)) {
        try {
            $ftp = ftp_connect("focus.immo", 21);
            ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
            ftp_pasv($ftp, true);
            $local_file = "downloaded.pdf";
            if (ftp_get($ftp, $local_file, $_SESSION["code"] . $remote . $file_name, FTP_BINARY)) {
                $file_new_name = stripAccents(trim($file_name));
                header("Content-Disposition: attachment; filename=\"" . $file_new_name . '"');
                readfile($local_file);
                unlink($local_file);
            }
            ftp_close($ftp);
        } catch (Exception $e) {
            //echo "Connexion échouée: " . $e->getMessage();
        }
    }
}
//header("Location: ../signed");
