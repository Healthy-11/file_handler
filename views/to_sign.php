<!doctype html>
<html lang="fr">
<?php require("header.php");?>
<body>
<?php
session_start();
require("nav.php");
?>
<div class="sticky">
    <div class="centered">
        <h1 class="whited">Envoi vers FTP</h1>
        <h3 class="whited">
            Choisir un ou des fichier(s) :
        </h3>
        <form action="/views/upload_file.php" enctype="multipart/form-data" method="POST">
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
        <img src="views/img/pdf.svg" width="50">
        <h3 class="list-h3"><?= $name ?></h3>
        <p class="list-p"><?= $info[5] . " " . $info[6] . " " . $info[7] ?></p>
        <p class="list-p"><?= $info[4] . " B" ?></p>
    </div>
<?php endforeach; ?>
</body>
