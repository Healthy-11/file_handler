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
            <input class="file_dl" name="upload[]" type="file" multiple="multiple"/>
            <button class="dl" name="file_sender" type="submit">Envoyer</button>
        </form>
    </div>
</div>
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
                    <input type="hidden" name="dlfileToSign" value="<?= $name ?>"/>
                    <button class="dl" name="download">Télécharger</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>

<?php
if (isset($_GET)) {
    if (isset($_GET["error"])) {
        $error = json_decode($_GET["error"]);
        $done = 0;
        $type = 0;
        $exception = 0;
        $name = 0;
        for ($i = 0; $i < sizeof($error); $i++) {
            if ($error[$i] == 0) {
                $done++;
            } else if ($error[$i] == 2) {
                $type++;
            } else if ($error[$i] == 1) {
                $exception++;
            } else if ($error[$i] == 3) {
                $name++;
            }
        }
        if ($done == 1) {
            echo '<script>$.notify("Un fichier téléchargé avec succès", "success");</script>';
        } else if ($done > 1) {
            echo '<script>$.notify("' . $done . ' fichiers téléchargés avec succès", "success");</script>';
        }

        if ($type == 1) {
            echo '<script>$.notify("Type d\'un fichier non supporté", "error");</script>';
        } else if ($type > 1) {
            echo '<script>$.notify("Types de ' . $type . ' fichiers non supportés", "error");</script>';
        }

        if ($exception == 1) {
            echo '<script>$.notify("Téléchargement d\'un fichier échoué", "error");</script>';
        } else if ($exception > 1) {
            echo '<script>$.notify("Téléchargement de ' . $exception . ' fichiers échoué", "error");</script>';
        }

        if ($name == 1) {
            echo '<script>$.notify("Téléchargement d\'un fichier impossible, nom déjà existant", "warn");</script>';
        } else if ($name > 1) {
            echo '<script>$.notify("Téléchargement de ' . $name . ' fichiers impossible, noms déjà existants", "warn");</script>';
        }
    }
    echo '<script>window.history.replaceState({}, document.title, "/" + "to_sign");</script>';
    unset($_GET);
}
