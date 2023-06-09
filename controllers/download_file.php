<?php
session_start();
include "../utils/functions.php";
if (isset($_POST['download'])) {
    if (isset($_POST['dlfileSigned'])) {
        $file_name = $_POST['dlfileSigned'];
        $remote_folder = "/signed/";
    }
    if (isset($_POST['dlfileToSign'])) {
        $file_name = $_POST['dlfileToSign'];
        $remote_folder = "/toSign/";
    }
    if (isset($file_name) && isset($remote_folder)) {
        try {
            $ftp = ftp_connect($_SESSION["config"]['ftp_url'], 21);
            ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
            ftp_pasv($ftp, true);
            $local_file = "downloaded.pdf";
            if (ftp_get($ftp, $local_file, $_SESSION["code"] . $remote_folder . $file_name, FTP_BINARY)) {
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
