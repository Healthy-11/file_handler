<?php
session_start();
$error = 0;
if (isset($_POST['file_sender'])) {
    try {
        $ftp = ftp_connect("focus.immo", 21);
        ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
        ftp_pasv($ftp, true);
        $total = count($_FILES['upload']['name']);
        if ($_FILES['upload']['type'] == "application/pdf") {
            for ($i = 0; $i < $total; $i++) {
                $file = $_FILES['upload']['tmp_name'][$i];
                $ret = ftp_nb_put($ftp, $_SESSION["code"] . "/toSign/" . $_FILES['upload']['name'][$i], $file, FTP_BINARY, FTP_AUTORESUME);
                while (FTP_MOREDATA == $ret) {
                    echo ">"; //display waiting
                    $ret = ftp_nb_continue($ftp);
                }
            }
        } else {
            $error = 2;
        }
        ftp_close($ftp);
    } catch (Exception $e) {
        $error = 1;
        //echo "Connexion échouée: " . $e->getMessage();
    }
}
header("Location: ../to_sign");