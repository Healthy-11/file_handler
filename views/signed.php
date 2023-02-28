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

        foreach ($files as $key): ?>
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
            $ext = explode(".", $name);
            $end_ext = end($ext);
            ?>
            <div class="tile <?= $end_ext ?>">
                <h3 class="list-h3"><?= preg_replace('/\\.[^.\\s]{3,4}$/', '', $name); ?></h3>
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
