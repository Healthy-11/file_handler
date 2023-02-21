<?php
session_start();
$error = 0;
if (isset($_POST['file_sender'])) {
    try {
        $ftp = ftp_connect("focus.immo", 21);
        ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
        ftp_pasv($ftp, true);
        $total = count($_FILES['upload']['name']);
        $accepted_values = array("application/pdf", "image/jpg", "image/png", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.wordprocessingml.template");
        for ($i = 0; $i < $total; $i++) {
            if (in_array($_FILES['upload']['type'][$i], $accepted_values)) {
                $file = $_FILES['upload']['tmp_name'][$i];
                $ret = ftp_nb_put($ftp, $_SESSION["code"] . "/toSign/" . $_FILES['upload']['name'][$i], $file, FTP_BINARY, FTP_AUTORESUME);
                while (FTP_MOREDATA == $ret) {
                    $ret = ftp_nb_continue($ftp);
                }
            } else {
                $error = 2;
                exit();
            }
        }
        ftp_close($ftp);
    } catch (Exception $e) {
        $error = 1;
    }
} else {
    $error = 1;
}
header("Location: ../to_sign?error=" . $error);