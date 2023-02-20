<!doctype html>
<html lang="fr">
<?php require("header.php"); ?>
<body>
<?php
$page = "to_sign";
require("nav.php");
include "functions.php";

?>
<div class="sticky">
    <div class="centered">
        <h2 class="whited">Envoi vers FTP</h2>
        <h3 class="whited">
            Choisir un ou des fichier(s) :
        </h3>
        <form action="/views/upload_file.php" enctype="multipart/form-data" method="POST">
            <input class="file_dl" name="upload[]" type="file" multiple="multiple" accept="application/pdf"/>
            <button class="dl" name="file_sender" type="submit">Envoyer</button>
        </form>
    </div>
</div>
<div class="wrapper">
    <div class="box">
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
                <p class="list-p"><?= displayDate($info[5], $info[6], $info[7]) ?></p>
                <form class="form_download" method="POST" action="/views/download_file.php">
                    <input type="hidden" name="dlfileToSign" value="<?= $name ?>"/>
                    <button class="dl" name="download">Télécharger</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
