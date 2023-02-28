<?php
function getUnsignedFiles() {
    $ftp = ftp_connect("focus.immo", 21);
    ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
    ftp_pasv($ftp, true);
    $files = ftp_rawlist($ftp, $_SESSION["code"] . "/toSign/");
    ftp_close($ftp);
    return $files;
}

function getSignedFiles() {
    $ftp = ftp_connect("focus.immo", 21);
    ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
    ftp_pasv($ftp, true);
    $files = ftp_rawlist($ftp, $_SESSION["code"] . "/signed/");
    ftp_close($ftp);
    return $files;
}
?>
