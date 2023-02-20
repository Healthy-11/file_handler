<!doctype html>
<html lang="fr">
<?php
require("header.php");
include "functions.php";

?>
<body>
<?php
$page = "signed";
require("nav.php") ?>
<div class="wrapper">
    <div class="box">
        <?php
        $ftp = ftp_connect("focus.immo", 21);
        ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
        ftp_pasv($ftp, true);
        $buff = ftp_rawlist($ftp, $_SESSION["code"] . "/signed/");
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
                    <input type="hidden" name="dlfileSigned" value="<?= $name ?>"/>
                    <button class="dl" name="download">Télécharger</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>