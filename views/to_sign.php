<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>A signer - FTP Sender</title>
</head>
<?php
session_start();
if (isset($_POST['file_sender'])) {
    try {
        $ftp = ftp_connect("focus.immo", 21);
        ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
        ftp_pasv($ftp, true);
        $total = count($_FILES['upload']['name']);
        for ($i = 0; $i < $total; $i++) {
            $file = $_FILES['upload']['tmp_name'][$i];
            $ret = ftp_nb_put($ftp, $_SESSION["code"] . "/toSign/" . $_FILES['upload']['name'][$i], $file, FTP_BINARY, FTP_AUTORESUME);
            while (FTP_MOREDATA == $ret) {
                echo ">"; //display waiting
                $ret = ftp_nb_continue($ftp);
            }
        }
        ftp_close($ftp);
    } catch (Exception $e) {
        //echo "Connexion échouée: " . $e->getMessage();
    }
}
?>
<body>
<?php
require("nav.php");
?>
<div class="sticky">
    <div class="centered">
        <h1>Envoi vers FTP</h1>
        <h3>
            Choisir un ou des fichier(s) :
        </h3>
        <form action="" enctype="multipart/form-data" method="POST">
            <input name="upload[]" type="file" multiple="multiple" accept="application/pdf"/>
            <br/><br/>
            <button name="file_sender" type="submit">
                <span>Envoyer</span>
            </button>
        </form>
    </div>
</div>
<br>
<?php
$ftp = ftp_connect("focus.immo", 21);
ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
ftp_pasv($ftp, true);
$buff = ftp_rawlist($ftp, $_SESSION["code"] . "/toSign/");
ftp_close($ftp);
foreach ($buff as $key): ?>
    <?php $info = explode(" ", preg_replace('/\s+/', ' ', $key));
    if ($info[8] == "." || $info[8] == "..") {
        continue;
    }
    $name = "";
    for ($i = 8; $i < sizeof($info); $i++) {
        if ($i > 8) {
            $name = $name . " " . $info[$i];
        } else {
            $name = $info[$i];
        }
    }
    ?>
    <div class="tile">
        <h3 class="list-h3"><?= $name ?></h3>
        <p class="list-p"><?= $info[5] . " " . $info[6] . " " . $info[7] ?></p>
        <p class="list-p"><?= $info[4] . " B" ?></p>
    </div>
<?php endforeach; ?>
</body>
</html>